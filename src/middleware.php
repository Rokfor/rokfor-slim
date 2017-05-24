<?php

use Slim\Exception\NotFoundException;
use Slim\Http\Response;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

/**
 * Database Check Middleware
 *
 * Checks if a database does exist and is initialized.
 *
 * @author Urs Hofer
 */


$app->add(function ($request, $response, $next) {
  // Check for Existing Database
  try {
    $_p = $this->db->PDO();
  } catch (Exception $e) {
    _mailer($this, "MYSQL:\n". $e->getMessage());
    return $this->settings['multiple_spaces'] === true
      ? $response->withRedirect($this->settings['unknow_space_redirect'])
      : $this->view->render($response->withStatus(404), 'error.jade', [
          "message" => $e->getMessage(),
          "help"    => "Check the database parameters in the <i>database.php</i> configuration file."
        ]);
  }

  // Check for Correct Database Setup
  try {
    $stmt = $_p->prepare("SELECT * FROM users");
    $stmt->execute();
  } catch (Exception $e) {

    $_messages = [];
    if ($this->db->insertSql($_messages)) {
      return $next($request, $response);
    }

    $_help = "Your database exists but cannot be initialized. Run <i>$ propel sql:insert</i> manually from the command line.";
    _mailer($this, "MYSQL:\n". $_help);
    return $this->view->render($response->withStatus(404), 'error.jade', [
      "message" => join('<br>', $_messages),
      "help"    => $_help
    ]);
  }
  return $next($request, $response);
});

/**
 * Trailing Slash Middleware
 *
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */


$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next($request, $response);
});

/**
 * IP Resolver Middleware
 *
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */


$app->add(function ($request, $response, $next) {
  $checkProxyHeaders = true;
  // Adding X-Real-IP to standard headers
  // Used in Nginx Proxy Environments
  $headersToInspect = [
    'X-Real-Ip',
    'Forwarded',
    'X-Forwarded-For',
    'X-Forwarded',
    'X-Cluster-Client-Ip',
    'Client-Ip'
  ];
  $trustedProxies = (array)$this->settings['trusted_proxies'];
  $ip = new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies, null, $headersToInspect);
  return $ip->__invoke($request, $response, $next);
});



/**
 * Settings Middleware
 *
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
  $this->view->offsetSet('translations', $this->translations);
  $this->view->offsetSet('paths', $this->paths);
  $this->view->offsetSet('fieldtypes', $this->fieldtypes);
  $response = $next($request, $response);
  return $response;
});

/**
 * Logging Middleware
 *
 * writes the current route to logfile
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
  $route = $request->getAttribute('route', null);
  if ($route) {
    $this->get('logger')->info("Rokfor ".$route->getPattern());
  }
  $response = $next($request, $response);
  return $response;
});

/**
 * Ajax Check Middleware
 *
 * compares the request mode and the settings.
 * throws a 404 page if a route is called via browser but not listed as browser route
 *
 * @author Urs Hofer
 */

$ajaxcheck = function ($request, $response, $next) {
  $settings = [
    '/rf/login',
    '/rf/forgot',
    '/rf/proxy',
    '/rf/logout',
    '/rf/dashboard',
    '/rf/',
    '/rf'
  ];
  $route = $request->getAttribute('route', null);
  if ($route) {
    $current = $route->getPattern();
    if (!$request->isXhr() && !in_array($current, $settings)) {
      return $response->withRedirect('/rf/login');
    }
  }
  $response = $next($request, $response);
  return $response;
};

/**
 * Authentification Middleware
 * If something failed, redirect to entry page
 *
 * based on slim-auth
 *
 * @author Urs Hofer
 */
try {
  $authentification = $container->get('slimAuthRedirectMiddleware');
} catch (Exception $e) {
/*  $authentification = function ($request, $response, $next) {
    if ($this->settings['multiple_spaces'] === true)
      return $response->withRedirect($this->settings['unknow_space_redirect']);
    else
      throw new NotFoundException($request, $response);
  };*/
}


/**
 * CSRF Protection
 *
 * based on slim-csrf.
 * additionally, adds the csrf data to the view. which makes it
 * easy to include in a template.
 *
 * @author Urs Hofer
 */

$csrf = function ($request, $response, $next) {
    $this->view->offsetSet('csrf', [
      'nameKey'   => $this->csrf->getTokenNameKey(),
      'valueKey'  => $this->csrf->getTokenValueKey(),
      'name'      => $request->getAttribute($this->csrf->getTokenNameKey()),
      'value'     => $request->getAttribute($this->csrf->getTokenValueKey())
      ]);
    $response = $next($request, $response);
    return $response;
};

/**
 * Route Hooks
 *
 * Route Hooks are configured in the backend and executed if a route matches...
 */

 $routeHook = function($request, $response, $next) {
   $route = $request->getAttribute('route', null)->getPattern();
   // Call Post Processor
   if ($route <> "/rf/login") {
     foreach (\FieldpostprocessorQuery::create() as $proc) {
       # code...
       if (stristr($route, $proc->getConfigSys()))
         $this->helpers->apiCall(
           $proc->getCode(),
           $proc->getSplit(),
           [
             "Route" => $route,
             "Data"  => $request->isPost()
                        ? $request->getParsedBody()
                        : []
           ]
         );
     }
   }
   $response = $next($request, $response);
   return $response;
 };

/**
 * Set up Rokfor Database with correct user
 *
 * based on the groups and fortemplate, forbooks and forissues n2n relations
 * stores the rights in $this->rights
 *
 * @author Urs Hofer
 */

$identificator = function ($request, $response, $next) {
  try {
    $identity = $this->authenticator->getIdentity();
  } catch (Exception $e) {
    $identity = null;
  }

  if ($identity) {
    if ($this->db->setUser($identity['id'])) {
      $this->view->offsetSet('__currentuser__', $this->db->getUser());
    }
    else {
      $route = $request->getAttribute('route', null);
      if ($route->getPattern() <> "/rf/login") {
        return $response->withRedirect('/rf/login');
      }
    }
  }
  $response = $next($request, $response);
  return $response;
};



/**
 * Check for read only key in header (Authorization: Bearer KEY) or as query param (?access_token=KEY)
 *
 * Rokfor checks for read only keys in headers if somebody wants to access a
 * resource via r/o api. In case of a public application like a website, r/o keys are public.
 *
 * Never expose r/w keys to the public. Treat them like passwords. Only use them with a proxy server
 * if you need public write access to a Rokfor System.
 *
 * @author Urs Hofer
 */

$apiauth = function ($request, $response, $next) {
  try {
    // Option Requests

    if ($request->isOptions()) {
      $response = $next($request, $response);
      return $response;
    }


    $response = $response->withHeader('Content-type', 'application/json');
    $apikey = false;
    $msg = "No key supplied";
    $route = $request->getAttribute('route', null);

    // Read API KEY - GET (R/O Requests) allow Key as QueryParam as well
    if ($request->getQueryParams()['access_token'] && $request->isGet()) {
      $apikey = $request->getQueryParams()['access_token'];
    }
    else {
      $bearer = $request->getHeader('Authorization');
      if ($bearer[0]) {
        preg_match('/^Bearer (.*)/', $bearer[0], $bearer);
        $apikey = $bearer[1];
      }
    }

    // Actions if a key is supplied

    if ((string)$apikey !== "") {

      // Get Requests: R-O Keys required

      if ($request->isGet()) {
        $u = $this->db->getUsers()
              ->filterByRoapikey($apikey)
              ->limit(1)
              ->findOne();
        if ($u) {
          $this->db->setUser($u->getId());
          $access = true;
          if (trim($this->db->getUser()['ip'])) {
            if (stristr($this->db->getUser()['ip'], $request->getAttribute('ip_address')) === false) {
              $msg = "IP not allowed: ".$request->getAttribute('ip_address');
              $access = false;
            }
          }
          if ($access === true) {
            $this->db->addLog('get_api', 'GET' , $request->getAttribute('ip_address'));
            $response = $next($request, $response);
            return $response;
          }
        }
        else $msg = "Wrong key supplied";
      }

      // Post Requests: JWT Token Required

      if ($request->isPost() || $request->isPut() || $request->isDelete()) {
        $signer = new Sha256();
        $token  = (new Parser())->parse((string) $apikey); // Parses from a string
        $u      = $this->db->getUsers()->findPk((int)$token->getClaim('uid'));

        $data   = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($_SERVER['HTTP_HOST']);
        $data->setAudience($_SERVER['HTTP_HOST']);

        if ($u && $token->verify($signer, $u->GetRwapikey()) && $token->validate($data)) {
          $this->db->setUser($u->getId());
          $access = true;
          if ($this->db->getUser()['ip']) {
            if (!stristr($this->db->getUser()['ip'], $request->getAttribute('ip_address'))) {
              $msg = "IP not allowed: ".$request->getAttribute('ip_address');
              $access = false;
            }
          }
          if ($access === true) {
            $this->db->addLog('post_api', 'POST' , $request->getAttribute('ip_address'));
            $response = $next($request, $response);
            return $response;
          }
        }
        else $msg = "Wrong key supplied";
      }

    }

    // Post Login Route
    // Only called on POST with Pattern /api/login

    else {
      if ($request->isPost() && $route->getPattern() == "/api/login") {
        $response = $next($request, $response);
        return $response;
      }
    }

    $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
    $r->getBody()->write(json_encode(["Error" => $msg]));
    return $r;
  }
  catch (Exception $e) {
    $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
    $r->getBody()->write(json_encode(["Error" => $e->getMessage()]));
    return $r;
   };
};

/**
 * Check for a redis cache entry. If there is one, send it.
 * Works only for GET Calls
 * Redis Cache is cleared on POST Calls. This is cleary not optimal,
 * since the cache is cleared on nearly most editing/backend calls.
 * But due to the fact that Rokfor works as a Api-First CMS for Websites,
 * Most website calls via API are cached after a editing process.
 * @author Urs Hofer
 */

$redis = function ($request, $response, $next) {

  $cluster_iterate = function ($callback)
  {
      $clientClass = get_class($this->redis['client']);

      foreach ($this->redis['client']->getConnection() as $nodeConnection) {
          $nodeClient = new $clientClass($nodeConnection, $this->redis['client']->getOptions());
          $callback($nodeClient);
      }
  };

  if ($this->redis['redis'] && ($request->isPost() || $request->isGet())) {
    $qt = microtime(true);

    $_calltype = substr($request->getUri()->getPath(), 0, 10) === "/api/proxy"
        ? "proxycall"
        : (
          substr($request->getUri()->getPath(), 0, 4) === "/api"
            ? "apicall"
            : false
        );

    // Call Cache on Get and Api Calls, But not on private file proxy calls
    if ($request->isGet() && $_calltype === "apicall") {
      // Create Transaction Hash
      $hash = md5($request->getUri()->getPath().$request->getUri()->getQuery().serialize($request->getHeader('Authorization')));
      // Send Cache
      $redis_expiration = $this->redis['client']->get('expiration');

      if ($this->redis['client']->exists($hash) === 1 && $this->redis['client']->exists($hash."-hash") === 1 && ($redis_expiration == false || time() < $redis_expiration)) {
        if ($request->getHeader('Hash')) {
          $response->getBody()->write($this->redis['client']->get($hash."-hash"));
        }
        else {
          $response->getBody()->write($this->redis['client']->get($hash));
        }
        return $response
          ->withAddedHeader('X-Redis-Cache', 'true')
          ->withAddedHeader('X-Redis-Expiration', $redis_expiration ? date('r', $redis_expiration) : -1 )
          ->withAddedHeader('X-Redis-Time', (microtime(true) - $qt))
          ->withAddedHeader('X-Cache-Hash', $hash);

      }
      // Send Original
      else {
        $response = $next($request, $response);
        $this->redis['client']->set($hash, $response->getBody());
        $_hash = json_encode(json_decode($response->getBody())->Hash);
        $this->redis['client']->set($hash."-hash", $_hash);

        if ($request->getHeader('Hash')) {
          // Cors to everybody. It's only a hash.
          $newresponse = new Response;
          return $newresponse
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('X-Cache-Hash', $hash)
            ->write($_hash);
        }
        else {
          return $response->withAddedHeader('X-Cache-Hash', $hash);
        }
      }
    }

    // Clear Cache on Post or Backend Calls
    if ($request->isPost() || $_calltype != "apicall") {
      $prefix = $this->redis['client']->getOptions()->__get('prefix')->getPrefix();
      if ($this->redis['cluster']) {
        $cluster_iterate(function ($nodeClient) {
            $prefix = $nodeClient->getOptions()->__get('prefix')->getPrefix();
            $keyspace = new \Predis\Collection\Iterator\Keyspace($nodeClient, "$prefix*");
            foreach ($keyspace as $key) {
              $key = substr($key, strlen($prefix));
              $nodeClient->del($key);
              $nodeClient->del($key."-hash");
            }
        });
      }
      else {
        $keys = $this->redis['client']->keys("*");
        $removed = 0;
        foreach ($keys as $key) {
          if (substr($key, 0, strlen($prefix)) == $prefix) {
            $key = substr($key, strlen($prefix));
            $this->redis['client']->del($key);
            $this->redis['client']->del($key."-hash");
          }
        }
      }
      $response = $next($request, $response);
      return $response;
    }

  }

  // Continue not cached.
  $response = $next($request, $response);
  return $response;
};


/**
 * Cors Options: Passed to all
 *
 * Rokfor does not restrict the api to a certain domain. Probably this can be changed in the future
 * when the R/W api is ready
 *
 * @author Urs Hofer
 */
$cors = function ($request, $response, $next) {
  $corsOptions = [];
  if (trim($this->db->getUser()['config']->cors->get) == "") {
    $cors_get = (array)$this->settings['cors']['ro'];
  }
  else {
    $cors_get = explode(',', trim($this->db->getUser()['config']->cors->get));
  }
  if (trim($this->db->getUser()['config']->cors->postputdel) == "") {
    $cors_ppd = (array)$this->settings['cors']['rw'];
  }
  else {
    $cors_ppd = explode(',', trim($this->db->getUser()['config']->cors->postputdel));
  }

  if ($request->isGet()) {
    $corsOptions = [
      "origin"            => $cors_get,
      "maxAge"            => 1728000,
      "allowCredentials"  => true,
      "allowMethods"      => array("GET", "OPTIONS")
    ];
  }
  /* 
    Option Requests Currently Send nothing, leave cors to allow all then
  */
  if ($request->isOptions()) {
    $corsOptions = [
      "origin"            => '*',
      "maxAge"            => 1728000,
      "allowCredentials"  => true,
      "allowMethods"      => array("GET", "OPTIONS", "POST", "PUT", "DELETE")
    ];
  }
  if ($request->isPost() || $request->isPut() || $request->isDelete()) {
    $corsOptions = [
      "origin"            => $cors_ppd,
      "maxAge"            => 1728000,
      "allowCredentials"  => true,
      "allowMethods"      => array("POST", "PUT", "DELETE")
    ];
  }
  $cors = new \CorsSlim\CorsSlim($corsOptions);
  return $cors->__invoke($request, $response, $next);
};
