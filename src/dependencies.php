<?php

// DIC configuration
use JeremyKendall\Password\Decorator\UpgradeDecorator;
use PHPMailer\PHPMailer;

$container = $app->getContainer();

function _mailer($c, $message, $die = false) {
  $settings = $c->get('settings')['mail'];
  if ($settings['active']) {
    $mail = new PHPMailer\PHPMailer;

    $mail->isSMTP();
    $mail->Host = $settings['smtphost'];
    $mail->SMTPAuth = $settings['smtpauth'];
    if ($settings['username'])
      $mail->Username = $settings['username'];
    if ($settings['password'])
      $mail->Password = $settings['password'];
    if ($settings['tls'] === true)
      $mail->SMTPSecure = 'tls';
    $mail->Port = $settings['port'];

    $mail->setFrom($settings['from']);
    $mail->addAddress($settings['to']);
    $mail->Subject = '[ROKFOR SLIM]: Crucial Error';
    $mail->Body    =  "ROKFOR Slim reported an important error:\n" .
                      "----------------------------------------\n" .
                      "\n" .
                      "$message\n" .
                      "\n" .
                      "----------------------------------------\n" .
                      "\n" .
                      "Best wishes,\n" .
                      "Rokfor";
    $mail->send();
  }
  if ($die) die();
};


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
    $host = explode('.', $_SERVER['HTTP_HOST']);
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
    _mailer($c, "MYSQL:\n". $e->getMessage(), true);
  }
  return $db;
};

$container['redis'] = function ($c) {
  $settings = require __DIR__ . '/../config/redis.php';
  $dbsettings = require __DIR__ . '/../config/database.php';

  if ($c->get('settings')['multiple_spaces'] === true) {
    $host = explode('.', $_SERVER['HTTP_HOST']);
    $dbsettings['dbname'] = preg_replace("/[^A-Za-z0-9-_]/", '', $host[0]);
  }


  if ($settings['redis']) {

    // Clusterd Setup

    $redis_config = [];

    if (is_array($settings['redis_ip'])) {
      foreach ($settings['redis_ip'] as $_key => $_redis_ip) {
        $redis_config[] = [
          'scheme' => 'tcp',
          'host' => $_redis_ip,
          'port' => (is_array($settings['redis_port']) && $settings['redis_port'][$_key]) ? $settings['redis_port'][$_key] : $settings['redis_port']
        ];
      }
    }
    else {
      $redis_config = [
        'scheme' => 'tcp',
        'host' => $settings['redis_ip'],
        'port' => $settings['redis_port']
      ];
    }

    $client = new \Predis\Client($redis_config, ['prefix'  => $dbsettings['dbname'].':', 'throw_errors' => false]);
    try {
        $client->connect();
    }
    catch (\Predis\Connection\ConnectionException $exception) {
      _mailer($c, "REDIS:\n". $exception->getMessage());
      return [
        'redis'   => false
      ];
    }
    return [
      'redis'   => $settings['redis'],
      'client'  => $client,
      'cluster' => is_array($settings['redis_ip'])
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
      $c['view']->render($c['response']->withStatus(404), 'error.jade', []);
      return $c['response'];
    };
};
