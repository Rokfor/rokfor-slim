<?php

use Slim\CallableResolver;
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
$GLOBALS[starttime] = microtime(true);
$GLOBALS[timers] = [];

/* To help the built-in PHP dev server, check if the request was actually for
 * something which should probably be served as a static file
 */
if (PHP_SAPI == 'cli-server') {
    $_SERVER['SCRIPT_NAME'] = "/index.php";
    ini_set('xdebug.max_nesting_level', 1000);
    ini_set('display_errors', 1);
    $_p = explode("?",__DIR__ . $_SERVER['REQUEST_URI']);
    $file = reset($_p);
    if (is_file($file)) {
        return false;
    }
    /*
     * Clear the template cache on every call
     * to keep the output up to date on template changes.
     */
    foreach (glob(__DIR__ . '/../cache/*') as $file) {
      unlink($file);
    }
}

require __DIR__ . '/../vendor/autoload.php';

// Start Session for backend calls

if (stristr($_SERVER['REQUEST_URI'], '/rf/') || stristr($_SERVER['REQUEST_URI'], 'backend=true')) {
  $session = require __DIR__ . '/../config/session.php';
  if ($session['handler'] === 'redis') {
    $redis_config = [
      'scheme' => 'tcp',
      'host' => $session['redis_ip'],
      'port' => $session['redis_port']
    ];
    $client = new \Predis\Client($redis_config, ['prefix'  => 'sessions:', 'throw_errors' => false]);
    try {
      $client->connect();
      $handler = new \Predis\Session\Handler($client, array('gc_maxlifetime' => ini_get('session.gc_maxlifetime')));
      $handler->register();
    }
    catch (\Predis\Connection\ConnectionException $exception) {
      /* Do nothing - fall back */
    }
  }
  session_start();    
}

// Instantiate the app
$settings = require __DIR__ . '/../config/settings.php';
date_default_timezone_set($settings['settings']['timezone']);
$app = new \Slim\App($settings);
$GLOBALS[timers]['a'] = microtime(true) - $GLOBALS[starttime];
// Set up acl
require __DIR__ . '/../src/acl.php';
$GLOBALS[timers]['b'] = microtime(true) - $GLOBALS[starttime];
// Set up dependencies
require __DIR__ . '/../src/dependencies.php';
$GLOBALS[timers]['c'] = microtime(true) - $GLOBALS[starttime];
// Set up helper functions
require __DIR__ . '/../src/helpers.php';
$GLOBALS[timers]['d'] = microtime(true) - $GLOBALS[starttime];
// Register middleware
require __DIR__ . '/../src/middleware.php';
$GLOBALS[timers]['e'] = microtime(true) - $GLOBALS[starttime];
// Register routes
require __DIR__ . '/../src/routes.php';
$GLOBALS[timers]['f'] = microtime(true) - $GLOBALS[starttime];
// Register API specific routes
require __DIR__ . '/../src/api.php';
$GLOBALS[timers]['g'] = microtime(true) - $GLOBALS[starttime];

// Run app
$app->run();
