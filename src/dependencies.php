<?php

// DIC configuration
use JeremyKendall\Password\Decorator\UpgradeDecorator;
use PHPMailer\PHPMailer;

$container = $app->getContainer();

function _mailer($c, $message, $die = false) {
  $settings = $c->get('settings')['mail'];
  if ($settings['active']) {
    $lasttime = file_get_contents($settings['lockfile']);
    $delta = time() - $lasttime;
    if ($delta > $settings['locktime']) {

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
                        "Server Info\n" .
                        "\n" .
                        print_r($_SERVER, true).
                        "\n" .
                        "Best wishes,\n" .
                        "Rokfor";
      $mail->send();
      file_put_contents($settings['lockfile'], time());
    }
  }
  if ($die) die();
};


/**
 *
 */
class Mailer
{

  function __construct($c)
  {
    $this->settings = $c->get('settings')['mail'];
  }

  function sendmail($to, $subject, $message) {
    $mail = new PHPMailer\PHPMailer;
    $mail->isSMTP();
    $mail->Host = $this->settings['smtphost'];
    $mail->SMTPAuth = $this->settings['smtpauth'];
    if ($this->settings['username'])
      $mail->Username = $this->settings['username'];
    if ($this->settings['password'])
      $mail->Password = $this->settings['password'];
    if ($this->settings['tls'] === true)
      $mail->SMTPSecure = 'tls';
    $mail->Port = $this->settings['port'];
    $mail->setFrom($this->settings['from']);
    $mail->addAddress($to);
    $mail->isHtml(true);
    $mail->Subject = $subject;
    $mail->CharSet = 'UTF-8';
    $mail->Body    = '<!DOCTYPE html>
    <html>
    <head>
    <meta content="width=device-width" name="viewport">
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>'.$subject.'</title>
    <style>
      @media screen and (max-width: 600px) {
        .h--1 {
          font-size: 22px !important;
        }
      }
      @media screen and (max-width: 600px) {
        .wrapper {
          width: 100% !important;
        }
      }
      .logo {
      background-color: rgb(54, 127, 169);
      border-bottom-color: rgba(0, 0, 0, 0);
      border-bottom-style: solid;
      border-bottom-width: 0px;
      box-sizing: border-box;
      color: rgb(255, 255, 255);
      display: block;
      font-size: 20px;
      height: 50px;
      line-height: 50px;
      text-align: center;
      width: 100%;
      }
      header {
        margin-bottom: 2em;
      }
    </style>
    </head>
    <body style="font-family: Arial, sans-serif; text-align: left; margin: 0; padding: 0;">
    <header class="main-header"><span style="width: 100%" class="logo"><img src="http://'.$_SERVER['HTTP_HOST'].'/assets/img/logo-w.svg"></span></header>
    <table border="0" cellpadding="0" cellspacing="0" class="wrapper" style="margin: auto; max-width: 100%; width: 600px;" width="600">
    <tr>
    <td>
    '.$message.'
    </td>
    </tr>
    </table>
    ';
    $mail->send();
  }
}

$container['sendmail'] = function ($c) {
  return (new Mailer($c));
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
  
  if ($c['request']->isOptions()) {
    return false;
  }
  
  $settings = require __DIR__ . '/../config/database.php';
  $rsettings = require __DIR__ . '/../config/redis.php';

  // Overrule DbName if multi Environment Setting is true

  if ($c->get('settings')['multiple_spaces'] === true) {
    $host = explode('.', $_SERVER['HTTP_HOST']);
    $settings['dbname'] = preg_replace("/[^A-Za-z0-9-_]/", '', $host[0]);
  }

  \TFC\Cache\DoctrineCacheFactory::setOption(
    array(
      'storage'     => 'redis',
      'prefix'      => 'rokfor-cache-'.$settings['dbname'],
      'host'        => $rsettings['redis_ip'],
      'port'        => $rsettings['redis_port'],
      'default_ttl' => 0
      )
  );   


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
  
  if ($c['request']->isOptions()) {
    return false;
  }
  
  // Example callback to validate a sha512 hashed password
  $callback = function ($password, $passwordHash, $salt) {
      if (hash('md5', $password ) === $passwordHash) {
          $_SESSION["releasenotification"]["notification_pwcrypt"] = true;  // Add a deprecation note.
          return true;
      }
      if (password_verify ( $password , $passwordHash )  === true ) {
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

if (!$container['request']->isOptions()) {
  $container->register(new \JeremyKendall\Slim\Auth\ServiceProvider\SlimAuthProvider());
}



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
