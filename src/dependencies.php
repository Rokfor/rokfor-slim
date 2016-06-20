<?php

// DIC configuration
use JeremyKendall\Password\Decorator\UpgradeDecorator;  

$container = $app->getContainer();

// translation settings
$container['translations'] = function ($c) {
  $locale = $c->get('settings')['locale'];
  setlocale(LC_ALL, $locale);
  $t = $c->get('settings')['translations'];
  return $t['strings'][$locale];
};

// path settings
$container['paths'] = function ($c) {
  return $c->get('settings')['paths'];
};

// fieldtypes settings
$container['fieldtypes'] = function ($c) {
  return $c->get('settings')['fieldtypes'];
};

// view renderer
$container['view'] = function ($c) {
  $settings = $c->get('settings')['view'];
  $view = new \Slim\Views\Jade($settings['template_path'], ['cache' => $settings['cache_path']]);
  return $view;
};


// monolog
$container['logger'] = function ($c) {
  $settings = $c->get('settings')['logger'];
  $logger = new Monolog\Logger('rokfor');
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
  return $logger;
};

// rokfor database & update paths
$container['db'] = function ($c) {
  $settings = require __DIR__ . '/../config/database.php';
  
  // Overrule DbName if multi Environment Setting is true
  
  if ($c->get('settings')['multiple_spaces'] === true) {
    $parsedUrl = parse_url($_SERVER['HTTP_HOST']);
    $host = explode('.', $parsedUrl['host']);
    $settings['dbname'] = preg_replace("/[^A-Za-z0-9-_]/", '', $host[0]);
  }
  
  
  try {
    $db = new Rokfor\DB(
        $settings['host'],
        $settings['user'],
        $settings['pass'],
        $settings['dbname'],
        $settings['log'], 
        $settings['level'],
        $c->paths,
        $settings['socket'],
        $settings['port'],
        $settings['versioning']
      );
  } catch (\PDOException $e) {
    die($e);
  }
  return $db;
};

$container['redis'] = function ($c) {
  $settings = require __DIR__ . '/../config/redis.php';
  $dbsettings = require __DIR__ . '/../config/database.php';
  
  if ($c->get('settings')['multiple_spaces'] === true) {
    $parsedUrl = parse_url($_SERVER['HTTP_HOST']);
    $host = explode('.', $parsedUrl['host']);
    $dbsettings['dbname'] = preg_replace("/[^A-Za-z0-9-_]/", '', $host[0]);
  }
  
  
  if ($settings['redis']) {
    return [
      'redis'   => $settings['redis'],
      'client'  => new \Predis\Client(
                    ['scheme' => 'tcp', 'host' => $settings['redis_ip'], 'port' => $settings['redis_port']],
                    ['prefix'  => $dbsettings['dbname'].':']
                   )
    ];
  }
  else {
    return [
      'redis'   => $settings['redis']
    ];
  }
};

// csrf middleware
$container['csrf'] = function ($c) {  
    return new \Slim\Csrf\Guard;  
};  


// auth middleware
$container['authAdapter'] = function ($c) {
  // Example callback to validate a sha512 hashed password  
  $callback = function ($password, $passwordHash, $salt) {  
      if (hash('md5', $password ) === $passwordHash) {  
          return true;  
      }  
      return false;  
  };  
  $validator = new UpgradeDecorator(new \JeremyKendall\Password\PasswordValidator(), $callback); 
  $adapter = new \JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter(
      $c->db->PDO(),
      "users",
      "username",
      "password",
      "usergroup",
      $validator
  );
  return $adapter;
};
$container['acl'] = function ($c) {
    return new \Rokfor\Acl();
};
$container['redirectNotAuthenticated']  = '/rf/login';
$container['redirectNotAuthorized']     = '/rf/login';
$container->register(new \JeremyKendall\Slim\Auth\ServiceProvider\SlimAuthProvider());


// flash messages
// Register provider
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};


//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
      $args = [];
      $c['view']->render($c['response']->withStatus(404), 'error.jade', $args);
      return $c['response'];
    };
};
