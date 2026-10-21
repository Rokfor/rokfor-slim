<?php
/**
 * API parity test
 *
 * Sends the same read-only GET requests to a reference and a candidate Rokfor
 * installation which share the same database, and compares the JSON responses.
 * Written for the PHP 7 -> PHP 8 migration: websites rely on the API data, so a
 * candidate must deliver exactly what the reference delivers.
 *
 * The request list is built from the reference API itself (books, issues,
 * chapters and every contribution reachable with the given read-only key),
 * so no database access is needed.
 *
 * Usage:
 *
 *   PARITY_KEY=<r/o api key> php tests/api-parity/parity.php \
 *     --reference=https://old.example.org --candidate=https://new.example.org
 *
 * Options:
 *
 *   --reference=URL      reference installation (e.g. PHP 7)
 *   --candidate=URL      candidate installation (e.g. PHP 8)
 *   --key=KEY            read-only api key (or env PARITY_KEY, preferred: keeps it
 *                        out of the shell history)
 *   --all-variants       request flat/depth/references variants for every
 *                        contribution, not only for every fifth one
 *   --flush              clear the api response cache (Redis) of both
 *                        installations first, by calling /rf/ping
 *   --limit=N            only send the first N requests (dry run)
 *   --parallel-ref=N     parallel requests to the reference (default 3)
 *   --parallel-cand=N    parallel requests to the candidate (default 3)
 *   --out=DIR            where report.json is written (default: next to this script, git-ignored)
 *
 * Compared: HTTP status and the complete JSON, including the order of lists.
 * Ignored: QueryTime and CachePerc. Hash is only counted, since it is an md5
 * over content that includes asset urls with the host name. Asset urls are
 * normalised: the host differs between installations by design, and the
 * scheme ("//" or "https://") follows the enforce_https setting.
 *
 * Caches: both installations may answer from the Redis response cache
 * (counted as cache hits, use --flush) or from the contributions cache in the
 * shared database. The latter is shared, so an entry written by one
 * installation can be served by the other. For a strict comparison empty the
 * _contributions_cache table before running.
 *
 * Exit code: 0 if all requests match, 1 otherwise.
 */

$opt = getopt('', ['reference:', 'candidate:', 'key:', 'all-variants', 'flush', 'limit:', 'parallel-ref:', 'parallel-cand:', 'out:']);
$reference = rtrim($opt['reference'] ?? '', '/');
$candidate = rtrim($opt['candidate'] ?? '', '/');
$key       = $opt['key'] ?? getenv('PARITY_KEY');
$out       = rtrim($opt['out'] ?? __DIR__, '/');
if (!$reference || !$candidate || !$key) {
  fwrite(STDERR, "usage: PARITY_KEY=<key> php " . $argv[0] . " --reference=URL --candidate=URL [--all-variants] [--flush] [--limit=N] [--out=DIR]\n");
  exit(2);
}

/**
 * GETs a list of paths from one installation, $parallel at a time.
 *
 * @return array path => [code, headers, body]
 */
function fetchAll($base, $paths, $key, $parallel) {
  $res = [];
  $queue = $paths;
  $active = [];
  $mh = curl_multi_init();
  $add = function () use (&$queue, &$active, $mh, $base, $key) {
    $p = array_shift($queue);
    if ($p === null) return;
    $h = curl_init($base . $p . (strpos($p, '?') !== false ? '&' : '?') . 'access_token=' . urlencode($key));
    curl_setopt_array($h, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_TIMEOUT => 300]);
    curl_multi_add_handle($mh, $h);
    $active[(int)$h] = [$h, $p];
  };
  for ($i = 0; $i < $parallel; $i++) $add();
  do {
    curl_multi_exec($mh, $running);
    curl_multi_select($mh, 1.0);
    while ($info = curl_multi_info_read($mh)) {
      [$h, $p] = $active[(int)$info['handle']];
      unset($active[(int)$info['handle']]);
      $raw = curl_multi_getcontent($h);
      $hs  = curl_getinfo($h, CURLINFO_HEADER_SIZE);
      $res[$p] = [
        'code'    => curl_getinfo($h, CURLINFO_RESPONSE_CODE),
        'headers' => substr($raw, 0, $hs),
        'body'    => substr($raw, $hs)
      ];
      curl_multi_remove_handle($mh, $h);
      $add();
    }
  } while ($running || $active || $queue);
  return $res;
}

function getJson($base, $path, $key) {
  $r = fetchAll($base, [$path], $key, 1)[$path];
  if ($r['code'] !== 200) {
    fwrite(STDERR, "$base$path returned HTTP {$r['code']}\n");
    exit(2);
  }
  return json_decode($r['body'], true);
}

/**
 * Removes volatile values and normalises host dependent urls.
 */
function normalise($v, $hosts) {
  if (is_array($v)) {
    unset($v['QueryTime'], $v['CachePerc'], $v['Hash']);
    foreach ($v as $k => $x) $v[$k] = normalise($x, $hosts);
    return $v;
  }
  if (is_string($v)) {
    foreach ($hosts as $h) {
      $v = str_replace(['https://' . $h, 'http://' . $h, '//' . $h], '<HOST>', $v);
    }
    $v = preg_replace('/X-Amz-(Date|Signature|Credential|Expires|Security-Token)=[^&"\s]*/', 'X-Amz-$1=<S3>', $v);
  }
  return $v;
}

/**
 * Collects up to $max human readable differences between two decoded responses.
 */
function differences($a, $b, $path, &$found, $max = 6) {
  if (count($found) >= $max) return;
  if (is_array($a) && is_array($b)) {
    $ka = array_keys($a);
    $kb = array_keys($b);
    if ($ka !== $kb) {
      $onlyA = array_values(array_diff($ka, $kb));
      $onlyB = array_values(array_diff($kb, $ka));
      $found[] = $onlyA || $onlyB
        ? "$path: keys only in reference " . json_encode($onlyA) . ", only in candidate " . json_encode($onlyB)
        : "$path: same keys, different order";
    }
    foreach ($a as $k => $x) {
      if (array_key_exists($k, $b)) differences($x, $b[$k], "$path.$k", $found, $max);
    }
    return;
  }
  if ($a !== $b) {
    $enc = function ($x) { return substr(json_encode($x, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 0, 100); };
    $found[] = "$path: " . $enc($a) . "  !=  " . $enc($b);
  }
}

// Flush the api response caches: any non-api request clears them (see $redis in src/middleware.php)

if (isset($opt['flush'])) {
  foreach ([$reference, $candidate] as $base) {
    $h = curl_init("$base/rf/ping");
    curl_setopt_array($h, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_HTTPHEADER => ['X-Requested-With: XMLHttpRequest']]);
    curl_exec($h);
    echo "flushed response cache of $base: HTTP " . curl_getinfo($h, CURLINFO_RESPONSE_CODE) . "\n";
  }
}

// Build the request list from the reference installation

$books = getJson($reference, '/api/books', $key)['Books'];
$urls = ['/api/books', '/api/issues', '/api/chapters', '/api/users'];
$combos = [];
$contributions = [];
foreach ($books as $book) {
  $urls[] = "/api/books/{$book['Id']}";
  $issues   = array_column($book['Issues'], 'Id');
  $chapters = array_column($book['Chapters'], 'Id');
  foreach ($issues as $id) $urls[] = "/api/issues/$id";
  foreach ($chapters as $id) $urls[] = "/api/chapters/$id";
  if (!$issues || !$chapters) continue;
  for ($offset = 0; ; $offset += 1000) {
    $docs = getJson($reference, '/api/contributions/' . implode('-', $issues) . '/' . implode('-', $chapters) . "?status=both&limit=1000&offset=$offset", $key)['Documents'] ?? [];
    foreach ($docs as $d) {
      $c = $d['Contribution'];
      $contributions[$c['Id']] = true;
      $combos[$c['Forissue'] . '/' . $c['Forchapter']] = $combos[$c['Forissue'] . '/' . $c['Forchapter']] ?? $c['Fortemplate'];
    }
    if (count($docs) < 1000) break;
  }
}
ksort($contributions);

$listVariants = ['', 'verbose=true', 'populate=true', 'status=both', 'references=false', 'flat=true', 'depth=2', 'sort=desc', 'limit=5&offset=2', 'refstatus=published', 'populate=true&verbose=true&status=both'];
$n = 0;
foreach ($combos as $combo => $template) {
  foreach ($listVariants as $v) $urls[] = "/api/contributions/$combo" . ($v ? "?$v" : '');
  $urls[] = "/api/contributions/$combo?template=$template";
  if ($n++ % 4 === 0) $urls[] = "/api/contributions/$combo?query=a&status=both";
}
$n = 0;
foreach (array_keys($contributions) as $id) {
  $urls[] = "/api/contribution/$id";
  $urls[] = "/api/contribution/$id?verbose=true";
  if ($n++ % 5 === 0 || isset($opt['all-variants'])) {
    $urls[] = "/api/contribution/$id?flat=true";
    $urls[] = "/api/contribution/$id?depth=2";
    $urls[] = "/api/contribution/$id?references=false";
  }
}
if (isset($opt['limit'])) $urls = array_slice($urls, 0, (int)$opt['limit']);
printf("%d books, %d issue/chapter combinations, %d contributions -> %d requests\n", count($books), count($combos), count($contributions), count($urls));

// Fetch and compare

$t = microtime(true);
$R = fetchAll($reference, $urls, $key, (int)($opt['parallel-ref'] ?? 3));
$tR = microtime(true) - $t;
$C = fetchAll($candidate, $urls, $key, (int)($opt['parallel-cand'] ?? 3));
$tC = microtime(true) - $t - $tR;

$hosts = [parse_url($reference, PHP_URL_HOST) . (parse_url($reference, PHP_URL_PORT) ? ':' . parse_url($reference, PHP_URL_PORT) : ''),
          parse_url($candidate, PHP_URL_HOST) . (parse_url($candidate, PHP_URL_PORT) ? ':' . parse_url($candidate, PHP_URL_PORT) : '')];
$stats = ['identical' => 0, 'different' => 0, 'status differs' => 0, 'hash differs' => 0, 'reference cache hits' => 0, 'candidate cache hits' => 0];
$report = [];
foreach ($urls as $p) {
  $r = $R[$p];
  $c = $C[$p];
  $hitR = stripos($r['headers'], 'X-Redis-Expiration') !== false;
  $hitC = stripos($c['headers'], 'X-Redis-Expiration') !== false;
  $stats['reference cache hits'] += $hitR;
  $stats['candidate cache hits'] += $hitC;
  $cache = ($hitR || $hitC) ? ' [cached: ' . ($hitR ? 'reference ' : '') . ($hitC ? 'candidate' : '') . ']' : '';
  if ($r['code'] !== $c['code']) {
    $stats['status differs']++;
    // Show the error of whichever side failed: Slim error page, or the JSON error
    $failed = $c['code'] >= 400 ? $c['body'] : $r['body'];
    $message = preg_match('#<strong>Type:</strong>\s*(.*?)</div>.*?<strong>Message:</strong>\s*(.*?)</div>.*?<strong>File:</strong>\s*(.*?)</div>.*?<strong>Line:</strong>\s*(\d+)#s', $failed, $m)
      ? html_entity_decode("$m[1]: $m[2] in " . preg_replace('#^.*/(src|lib|vendor)/#', '$1/', $m[3]) . ":$m[4]")
      : substr($failed, 0, 200);
    $report[] = ['url' => $p . $cache, 'differences' => ["HTTP {$r['code']} (reference) vs {$c['code']} (candidate): $message"]];
    continue;
  }
  $a = json_decode($r['body'], true);
  $b = json_decode($c['body'], true);
  if (($a['Hash'] ?? null) !== ($b['Hash'] ?? null)) $stats['hash differs']++;
  $na = normalise($a, $hosts);
  $nb = normalise($b, $hosts);
  if ($na === $nb && ($a !== null || $r['body'] === $c['body'])) {
    $stats['identical']++;
    continue;
  }
  $found = [];
  if ($a === null || $b === null) {
    $found[] = 'non-json body differs: ' . substr($c['body'], 0, 200);
  }
  else {
    differences($na, $nb, '$', $found);
  }
  $stats['different']++;
  $report[] = ['url' => $p . $cache, 'differences' => $found];
}

file_put_contents("$out/report.json", json_encode(['reference' => $reference, 'candidate' => $candidate, 'stats' => $stats, 'report' => $report], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
printf("reference %.0fs, candidate %.0fs\n", $tR, $tC);
foreach ($stats as $k => $v) echo str_pad($k, 22), $v, "\n";
foreach (array_slice($report, 0, 20) as $r) {
  echo "\n", $r['url'], "\n";
  foreach ($r['differences'] as $d) echo "    ", preg_replace('/\s+/', ' ', $d), "\n";
}
echo "\nfull report: $out/report.json\n";
exit($stats['different'] + $stats['status differs'] > 0 ? 1 : 0);
