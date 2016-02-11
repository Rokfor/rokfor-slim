<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = reset(explode("?",__DIR__ . $_SERVER['REQUEST_URI']));
    if (is_file($file)) {
        return false;
    }
}

foreach (glob(__DIR__ . '/../cache/*') as $file) {
  unlink($file);
}


require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';

date_default_timezone_set($settings['settings']['timezone']);

$app = new \Slim\App($settings);

// Set up acl
require __DIR__ . '/../src/acl.php';

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Set up helper functions
require __DIR__ . '/../src/helpers.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
