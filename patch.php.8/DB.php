<?php
namespace Rokfor;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * Rokfor DB
 *
 *
 * @package Rokfor.DB
 * @author Urs Hofer
 */

class DB
{

  /**
   * Propel ServiceContainer
   *
   * @var string
   */
  private $serviceContainer;

  /**
   * current user after login
   * required for all store actions
   *
   * @var string
   */
  private $currentUser;

  /**
   * Propel Manager
   *
   * @var string
   */
  private $manager;


  /**
   * Rights for a user
   *
   * @var array
   */
  private $rights;

  /**
   * paths for several upload actions
   *
   * @var array
   */
  private $paths;


  /**
   * proxy redirect prefix for private binary uploads
   *
   * @var string
   */
  //private $proxy_prefix;


  /**
   * s3 storage client
   *
   * @var string
   */
  private static $s3;

  function __construct($host, $user, $pass, $dbname, $log, $level, $patharray = [], $socket = false, $port = false, $versioning = false, $ATTR_EMULATE_PREPARES = false)
  {
    $socket = $socket
              ? "unix_socket=".$socket.";"
              : "";
    $port = $port
            ? "port=".$port.";"
            : "";

    $this->serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
    $this->serviceContainer->checkVersion('2.0.0-dev');
    $this->serviceContainer->setAdapterClass('rokfor', 'mysql');
    $this->manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
    $this->manager->setConfiguration(array (
      'adapter' => 'mysql',
      'classname' => 'Propel\\Runtime\\Connection\\DebugPDO',
      'dsn' => 'mysql:host='.$host.';'.$port.'dbname='.$dbname.';'.$socket,
      'user' => $user,
      'password' => $pass,
      'attributes' =>
      array (
        'ATTR_EMULATE_PREPARES' => $ATTR_EMULATE_PREPARES,
      ),
    ));
    $this->manager->setName('rokfor');
    $this->serviceContainer->setConnectionManager('rokfor', $this->manager);
    $this->serviceContainer->setDefaultDatasource('rokfor');

    $this->currentUser = false;
    $this->paths = [
      'sys'       => $patharray['sys']        ? $patharray['sys']         : __DIR__. '/../public',
      'privatesys'=> $patharray['privatesys'] ? $patharray['privatesys']  : __DIR__. '/../public',
      'web'       => $patharray['web']        ? $patharray['web']         : '/udb/',
      'webthumbs' => $patharray['webthumbs']  ? $patharray['webthumbs']   : '/udb/thumbs/',
      'thmbsuffix'=> $patharray['thmbsuffix'] ? $patharray['thmbsuffix']  : '-thmb.jpg',
      'scaled'    => $patharray['scaled']     ? $patharray['scaled']      : '-preview[*].jpg',
      'quality'   => $patharray['quality']    ? $patharray['quality']     :  75,
      'process'   => $patharray['process']    ? $patharray['process']     : ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/tiff'],
      'store'     => $patharray['store']      ? $patharray['store']       : ['application/zip', 'video/quicktime', 'video/mp4', 'video/webm', 'audio/mp3'],
      'icon'      => $patharray['icon']       ? $patharray['icon']        : 'thumb.jpg'
    ];
    $this->defaultLogger = new \Monolog\Logger('defaultLogger');
    $this->defaultLogger->pushHandler(new \Monolog\Handler\StreamHandler($log, $level));
    $this->serviceContainer->setLogger('defaultLogger', $this->defaultLogger);
    if (!$versioning) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
    }

    if ($patharray['s3'] === true) {
      static::$s3 = new \stdClass();

      static::$s3->client = new \Aws\S3\S3Client([
        'credentials' => array(
          'key'     => $patharray['s3_aws_key'],
          'secret'  => $patharray['s3_aws_secret'],
        ),
        'region'      => $patharray['s3_aws_region'],
        'endpoint'    => $patharray['s3_aws_endpoint'],
        'version'     => "2006-03-01",
        'use_path_style_endpoint' => true
      ]);

      static::$s3->bucket = $patharray['s3_aws_bucket'];
      static::$s3->public = $patharray['s3_aws_public_pages'];
      static::$s3->endpoint = $patharray['s3_aws_endpoint'];
      static::$s3->folder = md5($dbname);
      static::$s3->client->registerStreamWrapper();
    }
    else {
      static::$s3 = false;
    }

    $this->asset_prefix = '/asset/';
  }

  private static function schedulePromise($callable, ...$args)
  {
      register_shutdown_function(function ($callable, ...$args) {
          call_user_func($callable, ...$args);
      }, $callable, ...$args);
  }


  private function iptc_make_tag($rec,$dat,$val) {
    $len = strlen($val);
    if ($len < 0x8000) {
           return chr(0x1c).chr($rec).chr($dat).
           chr($len >> 8).
           chr($len & 0xff).
           $val;
    } else {
           return chr(0x1c).chr($rec).chr($dat).
           chr(0x80).chr(0x04).
           chr(($len >> 24) & 0xff).
           chr(($len >> 16) & 0xff).
           chr(($len >> 8 ) & 0xff).
           chr(($len ) & 0xff).
           $val;
           
    }
  }

  
  private function read_iptcdata($_file) {
    $__m = [];
    $_metadata = [];
    @getimagesize($_file, $__m);
    if (array_key_exists('APP13', $__m)) {
      $iptc = iptcparse($__m['APP13']);
      if (is_array($iptc)) {
        foreach ($iptc as $__key => $__value) {
          $_metadata[$__key] = $__value[0];
        }
      }
    }
    return $_metadata;
  }


  private function insert_iptc($_file, $_metadata) {
    if (!is_array($_metadata)) return false;
    $_metadata_combined = '';
    $__utf8seq = chr(0x1b) . chr(0x25) . chr(0x47);
    $__length = strlen($__utf8seq);
    $_metadata_combined = chr(0x1C) . chr(1) . chr('090') . chr($__length >> 8) . chr($__length & 0xFF) . $__utf8seq;
    foreach($_metadata as $__tag => $__string)
    {
        $__tag = substr($__tag, 2);
        $_metadata_combined .= $this->iptc_make_tag(2, $__tag, $__string);
    }
    $__data = iptcembed($_metadata_combined, $_file);
    file_put_contents($_file,$__data);
  }

  private function clean_regexp($s) {
    if ($_s = base64_decode($s)) {
      return preg_replace('/[^0-9A-Za-zäöüÄÖÜçôéàè|\\\[\]\?\^\$\.", ]/','', $_s);
    }
    return ("");
  }

  private function s3_upload($source, $dest, $private) {
    if (substr($dest, 0, 1) != '/') {
      $dest = '/'. $dest;
    }
    $result = static::$s3->client->putObject(array(
        'ACL'        => $private ? 'private' : 'public-read',
        'Bucket'     => static::$s3->bucket,
        'Key'        => static::$s3->folder . $dest,
        'SourceFile' => $source,
    ));
    $this->defaultLogger->info("uploaded $source with status " . ($private ? 'private' : 'public-read'));
    return pathinfo($result['ObjectURL'], PATHINFO_BASENAME);
  }

  function _add_proxy_single_file($url, $private = true, $contribution = false, $field = false) {
    return $this->asset_prefix.$contribution.'/'.$field.'/'.$url;
  }

  function presign_file($file, $public = false, $absolute = true) {
    if (static::$s3 !== false) {
      $key = static::$s3->folder . '/' . pathinfo($file, PATHINFO_BASENAME);
      $cmd = static::$s3->client->getCommand('GetObject', [
        'Bucket' => static::$s3->bucket,
        'Key' => $key
      ]);
      $request = static::$s3->client->createPresignedRequest($cmd, '+10 minutes');
      return (string)$request->getUri();
    }
    else {
      $path = $public === false
                ? $this->paths['privatesys']
                : $this->paths['sys'];
      if (file_exists($path.$this->paths['webthumbs'].$file))
        return (($absolute?$path:'').$this->paths['webthumbs'].$file);
      else if (file_exists($path.$this->paths['web'].$file))
        return (($absolute?$path:'').$this->paths['web'].$file);
      else
        return false;
    }
  }

  function s3_file_info($file) {
    $key = static::$s3->folder . '/' . pathinfo($file, PATHINFO_BASENAME);
    $result =  static::$s3->client->getObject(array(
        'Bucket' => static::$s3->bucket,
        'Key'    => $key
    ));
    return $result;
  }


  function _remove_proxy_single_file($url, $private = true) {
    return pathinfo($url, PATHINFO_BASENAME);
  }

  function sign_request(&$fields, $private = false, $contribution = false, $field = false) {
    if (is_array($fields)) {
      foreach ($fields as $key => &$v) {
        $v[1]              = $this->_add_proxy_single_file($v[1], $private, $contribution, $field);
        if (is_object($v[2])) {
          $v[2]->thumbnail = $this->_add_proxy_single_file($v[2]->thumbnail, $private, $contribution, $field);
          if (is_array($v[2]->scaled)) {
            foreach ($v[2]->scaled as &$s) {
              $s = $this->_add_proxy_single_file($s, $private, $contribution, $field);
            }
          }
        }
        else {
          $v[2]['thumbnail'] = $this->_add_proxy_single_file($v[2]['thumbnail'], $private, $contribution, $field);
          if (is_array($v[2]['scaled'])) {
            foreach ($v[2]['scaled'] as &$s) {
              $s = $this->_add_proxy_single_file($s, $private, $contribution, $field);
            }
          }
        }
      }
    }
  }


  function proxy($s3url, &$response) {
    /* S3 File Proxying */
    if (static::$s3 !== false) {
      $key = static::$s3->folder . '/' . pathinfo($s3url, PATHINFO_BASENAME);
      $this->defaultLogger->info("s3 proxying $key");
      if ($this->s3_file_exists($key)) {
        $result =  static::$s3->client->getObject(array(
            'Bucket' => static::$s3->bucket,
            'Key'    => $key
        ));
        $body = $result->get('Body');
        $body->rewind();
        $r = $response
                ->withHeader('Content-Type', $result['ContentType'])
                ->withHeader('Content-Length', $result['ContentLength'])
                ->withHeader('Content-Disposition', 'attachment; filename="'.pathinfo($s3url, PATHINFO_BASENAME).'"');

        $r->getBody()->write($body->read($result['ContentLength']));
      }
      else {
        $r = $response->withHeader('Content-type', 'application/json')->withStatus(404);
        $r->getBody()->write(json_encode(['Error' => "File not found"]));
      }
    }
    /* Local File Proxying: Always from private folder */
    else {
      $localfile = $this->paths['privatesys'].$s3url;
      if (file_exists($localfile)) {
        $this->defaultLogger->info("local proxying $localfile");
        $r = $response
                ->withHeader('Content-Type', mime_content_type($localfile))
                ->withHeader('Content-Length', filesize($localfile))
                ->withHeader('Content-Disposition', 'attachment; filename="'.basename($localfile).'"');
        $r->getBody()->write(file_get_contents($localfile));
      }
      else {
        $r = $response->withHeader('Content-type', 'application/json')->withStatus(404);
        $r->getBody()->write(json_encode(['Error' => "File not found"]));
      }
    }
    /* Return Response */
    return $r;
  }

  private function s3_move($source, $dest, $private) {
    $ObjectURL = $this->s3_upload($source, $dest, $private);
    @unlink($source);
    return $ObjectURL;
  }

  private function s3_unlink($filename) {
    $deleteFile = static::$s3->folder . '/' . pathinfo($filename, PATHINFO_BASENAME);
    try {
      $del = [
        'Bucket' => static::$s3->bucket,
        'Key' => $deleteFile,
      ];
      $promise = static::$s3->client->deleteObjectAsync($del);
      $this->schedulePromise([$promise, 'wait'],false);
    } catch (\Aws\S3Exception $e) {
      $this->defaultLogger->info($e->getMessage());
      return false;
    }
    $this->defaultLogger->info("s3 unlink $deleteFile");
    return true;
  }

  private function s3_file_exists($filename) {
//    $this->defaultLogger->info($deleteFile);
    $checkFile = static::$s3->folder . '/' . pathinfo($filename, PATHINFO_BASENAME);
    $keyExists = file_exists("s3://".static::$s3->bucket."/".$checkFile);
    if ($keyExists) {
      $this->defaultLogger->info("s3 file exists $checkFile");
    }
    return $keyExists;
  }

  private function s3_copy($source, $dest, $private) {
    $sourceFile = static::$s3->folder . '/' . pathinfo($source, PATHINFO_BASENAME);
    $destFile = static::$s3->folder . '/' . pathinfo($dest, PATHINFO_BASENAME);
    $promise = static::$s3->client->copyObjectAsync(array(
      'ACL'        =>  $private ? 'private' : 'public-read',
      'Bucket'      => static::$s3->bucket,
      'Key'         => $destFile,
      'CopySource'  => static::$s3->bucket. "/" . $sourceFile,
    ));
    $this->schedulePromise([$promise, 'wait'],false);
    //$destUrl = static::$s3->client->getObjectUrl(static::$s3->bucket, $destFile);
    //return pathinfo($destUrl, PATHINFO_BASENAME);
    return pathinfo($dest, PATHINFO_BASENAME);
  }


  private function copy($source, $dest) {
    return @copy($source, $dest);
  }

  private function unlink($path, $filename) {
    if (static::$s3 !== false) {
      return $this->s3_unlink($filename);
    }
    else {
      return @unlink($path . $filename);
    }
  }

  private function file_exists($filename) {
    if (static::$s3 !== false) {
      return $this->s3_file_exists($filename);
    }
    else {
      return file_exists($filename);
    }
  }

  private function RightsQuery() {
    return \RightsQuery::create();
  }

  private function BooksQuery() {
    return \BooksQuery::create();
  }

  private function ContributionsQuery() {
    return \ContributionsQuery::create();
  }

  private function IssuesQuery() {
    return \IssuesQuery::create();
  }

  private function FormatsQuery() {
    return \FormatsQuery::create();
  }

  private function TemplatenamesQuery() {
    return \TemplatenamesQuery::create();
  }

  private function TemplatesQuery() {
    return \TemplatesQuery::create();
  }

  private function DataQuery() {
    return \DataQuery::create();
  }

  private function UsersQuery() {
    return \UsersQuery::create();
  }

  private function Contributions() {
    return new \Contributions();
  }

  private function LogQuery() {
    return \LogQuery::create();
  }

  function ContributionsVersionQuery() {
    return \ContributionsVersionQuery::create();
  }

  function DataVersionQuery() {
    return \DataVersionQuery::create();
  }

  function DisableVersioning() {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      return true;
    }
    return false;
  }

  function EnableVersioning() {
    \ContributionsQuery::enableVersioning();
    \DataQuery::enableVersioning();
  }

  function PDO() {
    return $this->serviceContainer->getConnection()->getWrappedConnection()->getPdo();
  }

  function insertSql(&$messages = []) {
    $_manager = new \Propel\Generator\Manager\SqlManager();
    $_manager->setLoggerClosure(function ($message) {
      $_messages[] = $message;
    });
    $_manager->setConnections(["rokfor" => $this->manager->getConfiguration()]);
    $_manager->setWorkingDirectory(dirname(__FILE__).'/../config/generated-sql');
    return $_manager->insertSql("rokfor");
  }

  /**
   * returns true if the field has to be stored as json encoded string
   *
   * @param string $field
   * @return void
   * @author Urs Hofer
   */
  private function _determineJsonForField($field) {
    $settings = json_decode($field->getTemplates()->getConfigSys(), true);
    switch ($field->getTemplates()->getFieldtype()) {
      case 'Zahl':
        return false;
        break;
      case 'Text':
        if (!$settings['arrayeditor'])
          return false;
        break;
    }
    return true;
  }

  /**
   * deletes an array of files, inclusive possible thumbs and previews
   *
   * @param string $delete
   * @return void
   * @author Urs Hofer
   */
  function DeleteFiles($delete, $thumbs, $scaled, $private = false) {
    $path = $private === true
              ? $this->paths['privatesys']
              : $this->paths['sys'];

    if (is_array($delete))
      foreach ($delete as $file) {
        // Original
        $this->unlink($path.$this->paths['web'], $file);
      }
    if (is_array($thumbs))
      foreach ($thumbs as $file) {
        // Thumb
        $this->unlink($path.$this->paths['webthumbs'], $file);
      }
    if (is_array($scaled))
      foreach ($scaled as $file) {
        // Scaled Versions
        $this->unlink($path.$this->paths['web'], $file);
      }
  }

  /**
   * copies a file inclusive thumbs and scaled versions, returns the new filename
   *
   * @param string $delete
   * @return void
   * @author Urs Hofer
   */
  private function CopyFiles($file, $versions, $private) {
    $newversions = ['thumbnail' => "", 'scaled' => []];
    $copy_suffix = uniqid("_");
    $path = $private === true
              ? $this->paths['privatesys']
              : $this->paths['sys'];

    // Original
    $parts = pathinfo($file);
    $newname = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
    if (static::$s3 !== false) {
      $newname = $this->s3_copy($path.$this->paths['web'].$file, $path.$this->paths['web'].$newname, $private);
    }
    else {
      $this->copy($path.$this->paths['web'].$file, $path.$this->paths['web'].$newname);
    }


    // Thumb
    if ($versions['thumbnail']) {
      $parts = pathinfo($versions['thumbnail']);
      $newversions['thumbnail'] = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
      if (static::$s3 !== false) {
        $newversions['thumbnail'] = $this->s3_copy($path.$this->paths['webthumbs'].$versions['thumbnail'], $path.$this->paths['webthumbs'].$newversions['thumbnail'], $private);
      }
      else {
        $this->copy($path.$this->paths['webthumbs'].$versions['thumbnail'], $path.$this->paths['webthumbs'].$newversions['thumbnail']);
      }
    }

    // Scaled Versions

    foreach ($versions['scaled'] as $scaled) {
      $parts = pathinfo($scaled);
      $new_scaled = $parts['filename'].$copy_suffix.'.'.$parts['extension'];
      if (static::$s3 !== false) {
        $new_scaled = $this->s3_copy($path.$this->paths['web'].$scaled, $path.$this->paths['web'].$new_scaled, $private);
      }
      else {
        $this->copy($path.$this->paths['web'].$scaled, $path.$this->paths['web'].$new_scaled);
      }
      $newversions['scaled'][] = $new_scaled;
    }
    return array($newname, $newversions);
  }

  /**
   * return user object
   *
   * @return void
   * @author Urs Hofer
   */
  function getUser() {
    if (!$this->currentUser) return false;
    $level = false;
    switch ($this->currentUser->getUsergroup()) {
      case 'user':
        $level = 1;
        break;
      case 'admin':
        $level = 2;
        break;
      case 'root':
        $level = 3;
        break;
      default:
        $level = 0;
        break;
    }
    return [
      "id"        => $this->currentUser->getId(),
      "username"  => $this->currentUser->getUsername(),
      "level"     => $level,
      "role"      => $this->currentUser->getUsergroup(),
      "email"     => $this->currentUser->getEmail(),
      "api"       => $this->currentUser->getRoapikey(),
      "rwapi"     => $this->currentUser->getRwapikey(),
      "ip"        => $this->currentUser->getIp(),
      "config"    => json_decode($this->currentUser->getConfigSys()),
      "group"     => $this->currentUser->getRightss()->toArray()
    ];

  }


  /**
   * returns all users - only if logged in as root
   *
   * @return void
   * @author Urs Hofer
   */
  function getUsers() {
    return $this->usersQuery();
  }

  /**
   * checks email and username for existence
   *
   * @param string $checkUserName
   * @param string $checkUserEmail
   * @return void
   * @author Urs Hofer
   */
  function checkUser($checkUserName, $checkUserEmail, $checkPass = false, $ownId = false, &$err = false) {
    if ($err === false)
      $errors = [];
    else
      $errors = &$err;

    if ($checkPass && !$this->checkPasswordStrength($checkPass, $errors)) {
      return true;
    }

    if ($checkUserName != "" && $checkUserEmail != "") {
      $q = $this->UsersQuery()
              ->filterByEmail($checkUserEmail)
              ->_or()
              ->filterByUsername($checkUserName)
              ->_if($ownId)
                ->filterById($ownId, \Propel\Runtime\ActiveQuery\Criteria::NOT_EQUAL)
              ->_endif();
      if ($q->count() == 0) {
        return false;
      }
    }
    return true;
  }


  /**
   * creates a new user
   *
   * @return void
   * @author Urs Hofer
   */
  function newUser() {
    return new \Users();
  }

  /**
   * checks the password of the current user
   *
   * @param string $pw
   * @return void
   * @author Urs Hofer
   */
  function checkPassword($pw, &$mode = false) {
    if (md5($pw) == $this->currentUser->getPassword()) {
      $mode = 'md5';
      return true;
    }
    if (password_verify ( $pw , $this->currentUser->getPassword() ) === true ) {
      $mode = 'bcrypt';
      return true;
    }
    return false;
  }


  /**
   * returns the user query by Email
   *
   * @param string $email
   * @return void
   * @author Urs Hofer
   */
  function getUserByEmail($email) {
    $q = $this->UsersQuery()->filterByEmail($email);
    if ($q->count() > 0) {
      return $q;
    }
    else {
      return false;
    }
  }

  /**
   * password quality
   *
   * @param string $pwd
   * @param string $errors
   * @return void
   * @author Urs Hofer
   */
  private function checkPasswordStrength($pwd, &$errors) {
    $errors_init = $errors;
    if (strlen($pwd) < 8) {
        $errors[] = "password_too_short";
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors[] = "password_atleast_number";
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors[] = "password_atleast_letter";
    }
    return ($errors == $errors_init);
  }

  /**
   * sets a new passwor the password of the current user
   *
   * @param string $pw
   * @return void
   * @author Urs Hofer
   */
  function updatePassword($pw, $new1, $new2, &$error) {
    $hashmode = "";
    if ($new1 <> $new2) {
      $error[] = 'profile_error_pwnotmatch';
      return false;
    }
    if (!$this->checkPasswordStrength($new1, $error)) {
      return false;
    }
    if (!$this->checkPassword($pw, $hashmode)) {
      $error[] = 'profile_error_oldpwwrong';
      return false;
    }
    if ($new1 == $pw && $hashmode == 'bcrypt') {
      $error[] = 'profile_error_pwsameasold';
      return false;
    }
    $this->currentUser->setPassword(password_hash($new1, PASSWORD_DEFAULT))->save();
    return true;
  }



  function updateRemindedPassword($u, $new1, $new2, &$error) {
    if ($new1 <> $new2) {
      $error[] = 'profile_error_pwnotmatch';
      return false;
    }
    if (!$this->checkPasswordStrength($new1, $error)) {
      return false;
    }
    if ($new1 == $u->getPassword()) {
      $error[] = 'profile_error_pwsameasold';
      return false;
    }
    $u->setPassword(password_hash($new1, PASSWORD_DEFAULT))->save();
    return true;
  }









  /**
   * sets a new passwor the password of the current user
   *
   * @param string $pw
   * @return void
   * @author Urs Hofer
   */
  function updateProfile($name, $mail, $api, &$error, $rwapi = false, $ip = false, $config = false) {
    if (strlen($name) < 3) {
      $error[] = 'profile_error_nameempty';
      return false;
    }
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'profile_error_mail';
      return false;
    }
    if ($this->UsersQuery()->filterByUsername($name)->count() > 0 && $name <> $this->currentUser->getUsername()) {
      $error[] = 'profile_error_usernameexists';
      return false;
    }
    $this
      ->currentUser
      ->setUsername($name)
      ->setEmail($mail)
      ->setRoapikey($api)
      ->setRwapikey($rwapi)
      ->setIp(trim($ip))
      ->setConfigSys($config)
      ->save();
    return true;
  }


  /**
   * set user rights: Populates $this->rights and $this->currentUser
   *
   * @param Childobject\User $user
   * @return void
   * @author Urs Hofer
   */
  function setUser($userid) {
    $user = $this->UsersQuery()->findPk($userid);
    if ($user) {
      $this->currentUser = $user;
      switch ($user->getUsergroup()) {
        case 'admin':
        case 'root':
          $this->rights = [
            "role"  =>  $user->getUsergroup(),
            "books"     => true,
            "issues"    => true,
            "templates" => true,
            "formats"   => true
          ];
          break;
        case 'user':
          // Rights Classes for current user
          $rights = $this->RightsQuery()
                                ->useRRightsForuserQuery()
                                  ->filterByUserid($userid)
                                ->endUse()
                                ->find();
          foreach ($rights as $right) {
            $this->rights = [
                "role"  =>  $user->getUsergroup(),
                "books"     => $right->getBookss(),
                "issues"    => $right->getIssuess(),
                "templates" => $right->getTemplatenamess(),
                "formats"   => $right->getFormatss()
            ];
          }
          break;
        default:
          $this->rights = null;
          break;
      }
      return true;
    }
    else {
      $this->currentUser = false;
      $this->rights = null;
      return false;
    }
  }

  /**
   * returns a templatenames Query order by sort
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getTemplatenames() {
    return $this->TemplatenamesQuery()
                ->orderBySort('asc');
  }

  /**
   * returns a templatenames Object by PK
   *
   * @param int $id
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getTemplatename($id) {
    return $this->TemplatenamesQuery()
                ->findPk($id);
  }

  /**
   * returns a formats Query
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getFormats() {
    return $this->FormatsQuery();
  }

  /**
   * returns a formats Query
   *
   * @return \Childobject\Template
   * @author Urs Hofer
   */
  function getData() {
    return $this->DataQuery();
  }

  /**
   * returns rights query
   *
   * @return void
   * @author Urs Hofer
   */
  function getRights() {
    return $this->RightsQuery();
  }

  /**
   * returns book object by id
   *
   * @param int $id
   * @return Childobject\Book()
   * @author Urs Hofer
   */
  function getRight($id) {
    return $this->RightsQuery()->findPk($id);
  }

  /**
   * adds a right
   *
   * @return void
   * @author Urs Hofer
   */
  function newRight() {
    return new \Rights();
  }

  /**
   * returns a whole book/issue/chapter structure according to the
   * rights of the current user.
   * valid_paths is an array containing the md5 checksum as a key and
   * the corresponding chapter/issue/book name as value.
   * valid_paths are used to check if latest log entries are still pointing
   * to existing chapters and issues.
   *
   *
   * @param string $url_prefix
   * @return array
   * @author Urs Hofer
   */
  function getStructure($url_prefix = "", $bookid = false, &$valid_paths = []) {
    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn('__sort__');
    $retval = [];

    $books = $this->BooksQuery()
                  ->_if($bookid)
                    ->filterById($bookid)
                  ->_endif()
                  ->orderBySort('asc');

    foreach ($books as $book) {
      if ($this->rights["books"] === true || (is_object($this->rights["books"]) && in_array($book->getId(), $this->rights["books"]->getPrimaryKeys()))) {
        $c = [];
        $i = [];
        foreach ($book->getIssuess($criteria) as $issue) {
          if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issue->getId(), $this->rights["issues"]->getPrimaryKeys()))) {
            $c = [];
            foreach ($book->getFormatss($criteria) as $chapter) {
              if ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($chapter->getId(), $this->rights["formats"]->getPrimaryKeys()))) {
                $c[] = [
                  "chapter" => $chapter,
                  "name"    => $chapter->getName(),
                  "url"     => $url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId()
                ];
                $valid_paths[md5($url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId())] = [
                  "chapter" => $chapter->getName(),
                  "book"    => $book->getName(),
                  "issue"   => $issue->getName(),
                  "url"     => $url_prefix.$book->getId().'/'.$issue->getId().'/'.$chapter->getId()
                ];
              }
            }
            $i[]  = [
              "issue"     => $issue,
              "name"      => $issue->getName(),
              "status"    => $issue->getStatus(),
              "chapters"  => $c
            ];
          }
        }
        $retval[] = [
          "book"  => $book,
          "name"  => $book->getName(),
          "issues"  => $i,
          "chapters"  => $c
        ];
      }
      else {
        if ($bookid) {
          return false;
        }
      }
    }
    return $retval;
  }

  /**
   * returns available issues for a user
   *
   *
   * @param int $issueid
   * @return array
   * @author Urs Hofer
   */
  function getStructureByIssues($issueid = false) {
    $retval = [];

    $issues = $this->IssuesQuery()
                  ->_if($issueid)
                    ->filterById($issueid)
                  ->_endif()
                  ->orderBySort('asc');
    foreach ($issues as $issue) {
      if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issue->getId(), $this->rights["issues"]->getPrimaryKeys()))) {
        $retval[] = $issue;
      }
      else {
        if ($issueid) {
          return false;
        }
      }
    }
    return $retval;
  }

  /**
   * returns available chapters for a user
   *
   *
   * @param int $issueid
   * @return array
   * @author Urs Hofer
   */
  function getStructureByChapters($chapterid = false) {
    $retval = [];
    $formats = $this->FormatsQuery()
                  ->_if($chapterid)
                    ->filterById($chapterid)
                  ->_endif()
                  ->orderBySort('asc');
    foreach ($formats as $format) {
      if ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($format->getId(), $this->rights["formats"]->getPrimaryKeys()))) {
        $retval[] = $format;
      }
      else {
        if ($chapterid) {
          return false;
        }
      }
    }
    return $retval;
  }

  /**
   * return template id and name for a chapter
   * according to the current user
   *
   * @param string $format
   * @return void
   * @author Urs Hofer
   */
  function getTemplates($format) {
    $retval = [];
    foreach ($this->TemplatenamesQuery()->filterByFormats($format) as $template) {
      if ($this->rights["templates"]=== true || (is_object($this->rights["templates"]) && in_array($template->getId(), $this->rights["templates"]->getPrimaryKeys()))) {
        $retval[] = [
          "id"    => $template->getId(),
          "name"  => $template->getName()
        ];
      }
    }
    return $retval;
  }

  /**
   * return template id and name for a chapter
   * according to the current user
   *
   * @param string $format
   * @return void
   * @author Urs Hofer
   */
  function getTemplatefields() {
    return $this->TemplatesQuery();
  }

  /**
   * return template field by id
   *
   * @param string $format
   * @return void
   * @author Urs Hofer
   */
  function getTemplatefield($value) {
    return $this->TemplatesQuery()->findPk($value);
  }

  /**
   * reorder a bunch of contributions defined by their ids
   *
   * @param array $id
   * @return bool
   * @author Urs Hofer
   */
  
  /*function ReorderContributions($ids) {
    if (!is_array($ids))
      return false;
    $_s = 0;
    foreach ($ids as $value) {
      $this->ContributionsQuery()
        ->findPk($value)
        ->setSort($_s++)
        ->updateCache()
        ->save();
    }
    return true;
  }*/

  /**
   * delete a bunch of contributions defined by their ids or id
   * check if there are binaries linked to the files and delete them
   * from the server as well (call FileModify with empty data)
   *
   * @param mixed $id
   * @return void
   * @author Urs Hofer
   */
  function DeleteContributions($ids) {
    if (count($ids)> 10) {
      /* GET Contributions with image content */
      foreach ($this->getData()
                ->filterByForcontribution($ids)
                ->useTemplatesQuery()
                  ->filterByFieldname('Bild')
                ->endUse() as $_img_del) 
      {
        if ($_img_del->getContent()) {
          $this->FileModify($_img_del->getId(), []);
        }
      }

      /* DELETE CACHES */
      \ContributionscacheQuery::create()
        ->filterByForcontribution($ids)
        ->delete();

      foreach ($ids as $id) {
        \ContributionscacheQuery::create()
          ->filterByCache('%Contribution":{"Id":'.$id.'%') 
          ->_or()
          ->filterByCache('%"'.$id.'":%') 
          ->delete();
      }

      /* DELETE DATA */
      $this->getData()
            ->filterByForcontribution($ids)
            ->delete();

      /* DELETE CONTRIBUTIONS */
      $this->ContributionsQuery()
        ->filterById($ids)
        ->delete();

    } else {
      foreach ($ids as $id) {
        // Update Caches
        $contribution = $this->getContribution($id);
        $contribution->updateCache();

        $c = $this->ContributionsQuery()->findPk($id);
        $this->deleteData($c);
        // Update Contribution References
        $this->_clearReferencedObjects($c);
      }
      $this->ContributionsQuery()
        ->filterById($ids)
        ->delete();
      }    
  }

  /**
   * change the state a bunch of contributions defined by their ids or id
   *
   * @param mixed $ids
   * @param string $state
   * @return void
   * @author Urs Hofer
   */
  function ChangeStateContributions($ids, $state) {
    if (!in_array($state, ['Open', 'Draft', 'Close', 'Deleted']))
      return false;
    $this->ContributionsQuery()
      ->filterById($ids)
      ->update(array('Status' => $state));
  }

  /**
   * prepares the json statement for the config field of a new contribution
   *
   * @return void
   * @author Urs Hofer
   */
  function ContributionDefaultConfig() {
    return json_encode(['lockdate'=>time()]);
  }

  function NewContributionCache($contribution, $data = [], $hash = "") {
    $c = new \Contributionscache();
    $c->setContributions($contribution)
      ->setCache(json_encode($data))
      ->setSignature($hash)
      ->save();
  }


  function ResortContributions($issue, $format) {
    if (!$this->currentUser)
      return false;

    $_p = $this->PDO();
    $sql = 'UPDATE _contributions SET __sort__ = (@new_ordering := @new_ordering + @ordering_inc)
    WHERE _forissue = '.$issue->getId().' AND _forchapter = '.$format->getId().'
    ORDER BY __sort__ ASC';
    $_p->query('SET @ordering_inc = 2');
    $_p->query('SET @new_ordering = 0');
    $_p->query($sql);

    // Delete Caches

    $_p->query('DELETE FROM _contributions_cache
    WHERE _contributions_cache._forcontribution IN
    (SELECT id FROM _contributions WHERE _contributions._forissue = '.$issue->getId().' && _contributions._forchapter = '.$format->getId().')');

    return true;
//mysql> SET @ordering_inc = 10;
//mysql> SET @new_ordering = 0;
//mysql> UPDATE tasks SET ordering = (@new_ordering := @new_ordering + @ordering_inc) ORDER BY ordering ASC;


  }

  /**
   * NewContribution
   *
   * Adds a Contribution and Data Fields according to the given Template
   *
   * @param ChildIssues $issue
   * @param ChildFormats $format
   * @param int $templateid
   * @param string $name
   * @param string $status
   * @return $this|\Contributions Contribution
   * @author Urs Hofer
   */
  function NewContribution($issue, $format, $templateid, $name = "Empty Contribution", $status = "Open") {
    if (!$this->currentUser)
      return false;
    $template = $this->TemplatenamesQuery()->findPk($templateid);
    $last = $this->getContributions($issue->getId(), $format->getId(), 'desc')->findOne();
    if ($last)
      $_newsort = $last->getSort()+2;
    else
      $_newsort = 0;
    if (!$template)
      return false;
    if (!$template)
      return false;

    $c = new \Contributions();
    $c->setIssues($issue)
      ->setFormats($format)
      ->setTemplatenames($template)
      ->setStatus($status)
      ->setNewdate(time())
      ->setModdate(time())
      ->setName($name)
      ->setUserSysRef($this->currentUser)
      ->setSort($_newsort)
      ->setConfigSys($this->ContributionDefaultConfig())
      ->save();
    $_sort = 0;
    foreach ($this->TemplatesQuery()->filterByTemplatenames($template)->orderBySort('asc') as $templatefield) {
      $d = new \Data();
      $d->setContributions($c)
        ->setTemplates($templatefield)
        ->setUserSysRef($this->currentUser)
        ->setSort($_sort)
        ->setIsjson($d)
        ->save();
      $_sort++;
    }
    return $c;
  }

  /**
   * undocumented function
   *
   * @param array $ids
   * @param string $suffix
   * @return void
   * @author Urs Hofer
   */
  function CloneContributions($ids, $suffix) {
    if (!is_array($ids))
      return false;
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }

    $_reorder = [];

    foreach ($ids as $id) {
      $c = $this->ContributionsQuery()->findPk($id);
      $new = $c->copy(true);
      $new
        ->setName($c->getName() . "[".$suffix."]");

      $_reorder[] = [
        issue => $c->getIssues(),
        format => $c->getFormats()
      ];

      /* Clear References in New Contribution */
      if ($_nodes = json_decode($new->getConfigSys(), true)) {
        if ($_nodes["referenced"]) {
          $_nodes["referenced"] = [];
          $new->setConfigSys(json_encode($_nodes));
        }
      }

      /* Save */
      $new->save();
      /* Set Sort to new Id */
      $new
        ->setSort($new->getSort() + 1)
        ->save();

      $this->duplicateData($new);
    }

    foreach ($_reorder as $_r) {
      if ($_r[issue] && $_r[format]) {
        $this->ResortContributions($_r[issue], $_r[format]);        
      }
    }

    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }

  /**
   * Import Data from one contribution into another of the same type
   *
   * @param int $sourceid
   * @param int $destinationid
   * @return void
   * @author Urs Hofer
   */
  function ImportContribution($sourceid, $destinationid) {
    $_c = $this->getContribution($destinationid);
    $_source = $this->getContribution($sourceid);
    if ($_source && $_c->getFortemplate() == $_source->getFortemplate()) {
      $_olddata = [];
      foreach ($_source->getDatas() as $_data) {
        $_olddata[$_data->getFortemplatefield()] = $_data->getContent();
      }
      foreach ($_c->getDatas() as $_data) {
        $_data
          ->setContent($_olddata[$_data->getFortemplatefield()])
          ->save();
      }
      return $_source->getName();
    }
    else {
      return false;
    }
  }

  /**
   * Changes a Template of a contribution and delete/adds fields
   *
   * @param int $sourceid
   * @param int $destinationid
   * @return void
   * @author Urs Hofer
   */
  function ChangeTemplateContribution($contributionid, $templateid) {

    $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
    $criteria->addAscendingOrderByColumn('__sort__');
    $_template = $this->TemplatenamesQuery()->findPk($templateid);
    $_c = $this->getContribution($contributionid);
    $_oldfields = $_c->getDatas($criteria);
    $_newfields = $_template->getTemplatess($criteria);

    if ($_template) {
      // Delete Fields which are not used anymore
      $_delcount = 0;
      $_addcount = 0;
      $_modcount = 0;
      if (count($_oldfields) > count($_newfields)) {
        for ($delfield=count($_newfields); $delfield < count($_oldfields); $delfield++) {
          $this->deleteField($_oldfields[$delfield]);
          $_delcount++;
        }
      }
      // Fields of new Template
      $_sort = 0;
      foreach ($_newfields as $templatefield) {
        // Use old
        if ($_oldfields[$_sort]) {
          if ($_oldfields[$_sort]->getTemplates()->getFieldtype() == 'Bild' &&
          $_oldfields[$_sort]->getTemplates()->getFieldtype() != $templatefield->getFieldtype()) {
            $this->FileModify($_oldfields[$_sort]->getId(), []);
          }
          $d = $_oldfields[$_sort];
          $_modcount++;
        }
        // Insert if not existing
        else {
          $d = new \Data();
          $_addcount++;
        }
        $d->setContributions($_c)
          ->setTemplates($templatefield)
          ->setUserSysRef($this->currentUser)
          ->setSort($_sort)
          ->save();
        $_sort++;
      }
      // Update contributions reference
      $_c->setTemplatenames($_template)->save();
      return $_template->getName()." [+] $_addcount [-] $_delcount / [m] $_modcount";
    }
    else {
      return false;
    }
  }

  private function _getMimeType($file) {
    $type = $file->getClientMediaType();
    // Nasty Firefox Bug handeled here...
    if (stristr(strtolower($_SERVER['HTTP_USER_AGENT']), "firefox") && strtolower(pathinfo( $file->getClientFilename(), PATHINFO_EXTENSION)) === "pdf") {
      $type = "application/pdf";
    }
    return $type;
  }

  /**
   * FileStore
   *
   * Adds a upload to a Binary Field
   *
   * @author Urs Hofer
   * @param $fieldid     Field id
   * @param $files  PSR-7 Files Request
   * @param $urls   Array populated with the processed urls
   * @return bool   True on success, false on error
   * @throws \Propel\Runtime\Exception\PropelException*
   */
  function FileStore($fieldid, &$file, &$original_url, &$relative_url, &$thumb_url, &$caption, &$newindex, $default_caption = 'Caption') {
    $field = $this->getField($fieldid);
    $versions = ['thumbnail' => "", 'scaled' => []];
    if ($field) {

      // Private Storage
      $private = $field->getTemplates()->getTemplatenames()->getPublic() ? false : true;
      $path = $private === true
                ? $this->paths['privatesys']
                : $this->paths['sys'];

$this->defaultLogger->info("PRIVATE: " . $private);

      $settings = json_decode($field->getTemplates()->getConfigSys(), true);
      $oldVal   = json_decode($field->getContent(), true);
      $origsize = false;
      if (!$oldVal) {
        $oldVal = [];
      }

      // Check passed default captions
      if (count($settings['caption_variants']) == 1) {
        if (is_array($default_caption)) {
          $caption = (string)$default_caption[0];
        }
        else {
          $caption = $default_caption;
        }
      }
      else {
        $caption = [];
        foreach ($settings['caption_variants'] as $_key=>$_cap_variant) {
          if (is_array($default_caption)) {
            $caption[] = $default_caption[$_key] ? $default_caption[$_key] : $default_caption[0];
          }
          else {
            $caption[] = $default_caption;
          }
        }
      }

      if ($settings["growing"]==false) {
        $caption = $default_caption != 'Caption'  // Assume it's other than default
                    ? $default_caption            // Use the passed caption
                    : ($oldVal[0][0] ? $oldVal[0][0] : $default_caption); // Fallback old caption, if none, use default
        $oldVal = [];
        $this->FileModify($fieldid, $oldVal);
      }

      // Escape File Name
      $escapedFileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientFilename());
      while ($this->file_exists($path.$this->paths['web'].$escapedFileName)) {
        $escapedFileName = time()."_".$escapedFileName;
        $this->defaultLogger->info("APPENDING: " . $escapedFileName);
      }

      // Process
      if (in_array($this->_getMimeType($file), $this->paths['process']) && ($settings['imagesize'][0]['width'] || $settings['imagesize'][0]['height'])) {

        $file->moveTo($path.$this->paths['web'].$escapedFileName);
        $origsize = getimagesize($path.$this->paths['web'].$escapedFileName);

        // Class
        $driver = (in_array('Imagick', get_declared_classes()) ? 'imagick' : 'gd');
        $manager = new \Intervention\Image\ImageManager(array('driver' => $driver));
        $supported_types = $driver == 'imagick'
                            ? ['image/jpeg' => 'jpg',
                               'image/jpg'  => 'jpg',
                               'image/png'  => 'png',
                               'image/gif'  => 'gif']
                            : ['image/jpeg' => 'jpg',
                               'image/jpg'  => 'jpg',
                               'image/gif'  => 'gif'];

        // PDF Exception
        $_pdf_blob = false;
        if ($driver == 'imagick' && $this->_getMimeType($file) == 'application/pdf') {
          $Imagick = new \Imagick();
          $Imagick->readImage($path.$this->paths['web'].$escapedFileName.'[0]'); 
          $Imagick->setImageFormat("jpeg");
          $_pdf_blob = $Imagick->getImageBlob();
        }


        // Thumbnail
        $image = $manager->make($_pdf_blob ? $_pdf_blob : $path.$this->paths['web'].$escapedFileName);

        // Exif & IPCT

        $_metadata = false;

        if ($_pdf_blob === false) {
          $_metadata = $this->read_iptcdata($path.$this->paths['web'].$escapedFileName);
        }
        

        $image->fit(100,100);
        // Strip Profile Data
        if ($driver === 'imagick') {
          try {$image->getCore()->stripImage();}
          catch (Exception $e) {}
        }
        $image->save($path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'], $this->paths['quality']);

        // S3 Storage
        if (static::$s3 !== false) {
          $thumb_url = $this->s3_move($path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix'], $escapedFileName.$this->paths['thmbsuffix'], $private);
          $versions['thumbnail'] = $thumb_url;
        }
        else {
          $thumb_url = $escapedFileName.$this->paths['thmbsuffix'];
          $versions['thumbnail'] = $escapedFileName.$this->paths['thmbsuffix'];
        }

        $_copy = 0;
        foreach ($settings['imagesize'] as $size_per_image) {
          $image = $manager->make($_pdf_blob ? $_pdf_blob : $path.$this->paths['web'].$escapedFileName);
          $width = $size_per_image['width'];
          $height = $size_per_image['height'];
          // Resize and Copy to width and height
          $_ext = str_replace('[*]', $_copy++, $this->paths['scaled']);

          // Keep File Type if possible: otherwise make a jpeg.
          // If no [ext] is avaible, nothing happens.

          $_suffix = $supported_types[$this->_getMimeType($file)] ? $supported_types[$this->_getMimeType($file)] : 'jpg';
          $_ext = str_replace('[ext]', $_suffix, $_ext);

          $_processfile = $escapedFileName.$_ext;

          $height = $height == 0 ? null : $height;
          $width  = $width  == 0 ? null : $width;

          $image->resize($width,$height, function ($constraint) {
            $constraint->aspectRatio();
          });
    
          if ($driver === 'imagick') {
            try {
              $_core = $image->getCore();
              $_core->stripImage();
            }
            catch (Exception $e) {}
          }

          $image->save($path.$this->paths['web'].$_processfile, $this->paths['quality']);

          // Write Back Metadata if jpg & metadata

          if ($_suffix === 'jpg' && $_metadata !== false) {
            $this->insert_iptc($path.$this->paths['web'].$_processfile, $_metadata);
          }

          // S3 Storage
          if (static::$s3 !== false) {
            array_push($versions['scaled'], $this->s3_move($path.$this->paths['web'].$_processfile, $escapedFileName.$_ext, $private));
          }
          else {
            array_push($versions['scaled'], $escapedFileName.$_ext);
          }
        }

        if (static::$s3 !== false) {
          $original_url = $this->s3_move($path.$this->paths['web'].$escapedFileName, $escapedFileName, $private);
        }
      }
      // Move & Create a fake thumbnail
      // Also for process mime types which just failed because of missing size parameters
      else if (in_array($this->_getMimeType($file), $this->paths['store']) || in_array($this->_getMimeType($file), $this->paths['process'])) {
        $file->moveTo($path.$this->paths['web'].$escapedFileName);

        // S3 Storage
        if (static::$s3 !== false) {
          $original_url = $this->s3_move($path.$this->paths['web'].$escapedFileName, $escapedFileName, $private);
          $thumb_url = $this->s3_upload($path.$this->paths['webthumbs'].$this->paths['icon'], $escapedFileName.$this->paths['thmbsuffix'], $private);
          $versions['thumbnail'] = $thumb_url;
        }
        else {
          $this->copy($path.$this->paths['webthumbs'].$this->paths['icon'], $path.$this->paths['webthumbs'].$escapedFileName.$this->paths['thmbsuffix']);
          $thumb_url = $escapedFileName.$this->paths['thmbsuffix'];
          $versions['thumbnail'] = $escapedFileName.$this->paths['thmbsuffix'];
        }
      }
      // Unknown Type: Do not accept and return false
      else {
        $original_url = false;
        $thumb_url = false;
        $relative_url = false;
        return false;
      }

      // Update References
      if (static::$s3 === false) {
        // Attach to Data
        $newindex = array_push($oldVal, [$caption, $escapedFileName, $versions, $origsize]);
        $original_url = $escapedFileName;
        $relative_url = $escapedFileName;
      }
      else {
        // Attach to Data
        $newindex = array_push($oldVal, [$caption, $original_url, $versions, $origsize]);
        $relative_url = $original_url;
      }
      // Store
      $field->setContent(json_encode($oldVal))
        ->setIsjson(true)
        ->save();
      // Proxify if private
//      if ($private === true || static::$s3 !== false) {
//      echo("$original_url / $thumb_url / $relative_url \n");
        $original_url = $this->_add_proxy_single_file($original_url, $private, $field->getForcontribution(), $fieldid);
        $thumb_url    = $this->_add_proxy_single_file($thumb_url, $private, $field->getForcontribution(), $fieldid);
        $relative_url = $this->_add_proxy_single_file($relative_url, $private, $field->getForcontribution(), $fieldid);
//      die("$original_url / $thumb_url / $relative_url");
//      }
      return true;
    }
    else
      return false;
  }


  /**
   * BinaryModify
   *
   * Adds a upload to a Binary Field
   * @param int $fieldid
   * @param json $tabledata
   * @param string $caption
   * @return bool
   */
  function FileModify($fieldid, $tabledata) {
    $field = $this->getField($fieldid);
    if (!is_array($tabledata))
      $tabledata = [];
    if ($field) {

      // Deproxify Private Binaries
      if (!$field->getTemplates()->getTemplatenames()->getPublic()) {
        $private = true;
      }
      else {
        $private = false;
      }

      $olddata  = json_decode($field->getContent(), true);
      $oldimages = [];
      if (is_array($olddata)) {
        foreach ($olddata as $i) {
          $oldimages[$i[1]] = $i;
        }
      }

      // Copy scaled versions from old data
      foreach ($tabledata as $key => $i) {
        $tabledata[$key][1] = $this->_remove_proxy_single_file($i[1], $private);
        $this->defaultLogger->info($tabledata[$key][1]);
      }
      foreach ($tabledata as $key => $i) {
        if ($oldimages[$i[1]][1] === $i[1]) {
          $tabledata[$key][2] = $oldimages[$i[1]][2];
          $tabledata[$key][3] = $oldimages[$i[1]][3];
          unset($oldimages[$i[1]]);
        }
      }

       $this->defaultLogger->info("TO DELETE: " . join(",",array_keys($oldimages)));

      // Oldimages has now all the rest which does not exist in the new data
      $delete = [];
      $thumbs = [];
      $scaled = [];
      foreach ($oldimages as $i) {
        $delete[] = $i[1];
        if ($i[2]['thumbnail']) {
          $thumbs[] = $i[2]['thumbnail'];
        }
        if (is_array($i[2]['scaled'])) {
          $scaled  = array_merge($scaled, $i[2]['scaled']);
        }
      }
      $this->DeleteFiles($delete, $thumbs, $scaled, $private);

      $this->defaultLogger->info("ORIG: " . join(",", $delete));
      $this->defaultLogger->info("THMB: " . join(",", $thumbs));
      $this->defaultLogger->info("SCLD: " . join(",", $scaled));
      $this->defaultLogger->info("STORE: " . print_r($tabledata, true));

      //      print_r($delete);
      //      print_r($newdata);
      //      print_r($olddata);
      $field->setContent(json_encode($tabledata))
        ->setIsjson(true)
        ->save();
      return true;
    }
    else
      return false;
  }

  /**
   * sets the value of a referenced field to -1 if the source object is deleted
   *
   * @param string $source
   * @return void
   * @author Urs Hofer
   */
  private function _clearReferencedObjects($source) {
    /*$_id = $source->getId();
    if ($_id) {
      if ($_nodes = json_decode($source->getConfigSys())) {
        if (is_array($_nodes->referenced)) {
          foreach ($_nodes->referenced as $fieldId => $refContrib) {
            $_f = $this->getField($fieldId);
            if ($_f) {
              $_oldval = $_f->getDataAlwaysAsArray();
              // Delete this reference from valoues
              if(($key = array_search($_id, $_oldval)) !== false) {
                  unset($_oldval[$key]);
              }
              // Set to Disabled if no values are left
              if (sizeof($_oldval) == 0) {
                $_oldval[] = -1;
              }
              $_f->setContent(json_encode($_oldval))->save();
            }
          }
        }
      }
    }*/
  }


  private function _clearCache($id, $name, $type = false) {
      $name = json_encode($name);
      $name = str_replace('\u','\\\\u',$name);
      \ContributionscacheQuery::create()
      ->filterByCache('%"'.$id.'":{"Id":'.$id.',"Name":'.$name.'%')
      ->_if($type)
        ->_or()
        ->filterByCache('%"'.$type.'":'.$name.'%')
      ->delete();
  }

  /**
   * updates the contribution backreferences stored in the _config_ field of a contribution
   *
   * @param string $field
   * @param string $data
   * @return void
   * @author Urs Hofer
   */
  private function _updateReferencedObjects($field, $data = []) {
    $type     = $field->getTemplates();
    if ($type->getFieldtype() == "TypologySelect" || $type->getFieldtype() == "TypologyKeyword") {
      $settings = json_decode($type->getConfigSys());
      $decoded  = (is_array($data) || is_object($data) || is_numeric($data))
                  ? $data
                  : json_decode($data);
      $getAction = false;
      $queryAction = false;
      switch ($settings->history_command) {
        case 'contributional':
          $getAction = 'setRContributions';
          $queryAction = 'ContributionsQuery';
          break;
        case 'books':
          $getAction = 'setRBooks';
          $queryAction = 'BooksQuery';
          break;
        case 'issues':
          $getAction = 'setRIssues';
          $queryAction = 'IssuesQuery';
          break;
        case 'chapters':
          $getAction = 'setRFormats';
          $queryAction = 'FormatsQuery';
          break;
        case 'structural':
          $getAction = 'setRTemplates';
          $queryAction = 'TemplatesQuery';
          break;
        //case 'self':
        case 'other':
          $getAction = 'setRDataRefs';
          $queryAction = 'DataQuery';
          break;
      }
      if ($getAction && $queryAction) {
        $field->$getAction($this->$queryAction()->filterById($decoded)->find());
      }
    }
  }



  /**
   * setField
   *
   * Stores the Data of a specific Field
   * If the field has a json attribut set to true and the data is of type object
   * or array, the data will be transformed into a json string before save.
   *
   * @param integer $fieldid Data Field Primary Key
   * @param mixed $data Either jsonized string, plain string or $FILES array
   * @param string $action either NULL, add, delete or modify
   * @param string $idx
   * @return void
   * @author Urs Hofer
   */

  function setField($fieldid, &$data) {
    $field = $this->getField($fieldid);
    if ($field) {
      $tname = $field->getTemplates()->getTemplatenames();
      $access = ($this->rights["templates"]=== true || is_object($this->rights["templates"]) && in_array($tname->getId(), $this->rights["templates"]->getPrimaryKeys()));
      if ($access) {
        // Update Contributional References for Relative Fields
        $this->_updateReferencedObjects($field, $data);
        // Json is always true unless it is a number or a plain text field
        $field->setIsjson($this->_determineJsonForField($field));

        if ((is_array($data) || is_object($data))) {
          $data = json_encode($data);
        }
        $field->setContent($data)->save();
        return true;
      }
      else return "access failed";
    }
    else
      return false;
  }

  /**
   * deletes a field, and if it is of binary type, the associated files as well
   *
   * @param \Childobject\Field $field
   * @return void
   * @author Urs Hofer
   */
  function deleteField($field) {
    if ($field->getTemplates()->getFieldtype() == "Bild") {
      $this->FileModify($field->getId(), []);
    }
    $field->delete();
  }

  /**
   * returns data object by id
   *
   * @param int $id
   * @return Childobject\Data()
   * @author Urs Hofer
   */
  function getField($id) {
    return $this->DataQuery()->findPk($id);
  }

  /**
   * returns book object by id
   *
   * @param int $id
   * @return Childobject\Book()
   * @author Urs Hofer
   */
  function getBook($id) {
    return $this->BooksQuery()->findPk($id);
  }

  /**
   * returns all books
   *
   * @param int $id
   * @return Childobject\Book()
   * @author Urs Hofer
   */
  function getBooks() {
    return $this->BooksQuery();
  }

  /**
   * returns Format object by id
   *
   * @param int $id
   * @return Childobject\Format()
   * @author Urs Hofer
   */
  function getFormat($id) {
    return $this->FormatsQuery()->findPk($id);
  }

  /**
   * returns Issue object by id
   *
   * @param int $id
   * @return Childobject\Issue()
   * @author Urs Hofer
   */
  function getIssue($id) {
    return $this->IssuesQuery()->findPk($id);
  }

  /**
   * returns all Issues
   *
   * @param int $id
   * @return Childobject\Issue()
   * @author Urs Hofer
   */
  function getIssues() {
    return $this->IssuesQuery();
  }

  /**
   * returns Contributions Collection by issue and chapter
   *
   * @param int $issueid
   * @param int $chapterid
   * @return Childcollection\ContributionsQuery()
   * @author Urs Hofer
   */
  function getContributions($issueid, $chapterid, $sortmode = 'asc', $status = false, $limit = false, $offset = false, $count = false, $templateid = false) {


    /**
     * Sort Mode
     *
     **/

    $sort = [];
    $directions = [];

    // Default:
    if ($sortmode == "asc" || $sortmode == "desc") {
      $directions[] = $sortmode;
      $sort[] = 'orderBySort';
    }
    else {
      list($_sortarray,$_direction) = explode(":", $sortmode);
      $directions = (array)explode("|", $_direction);
      foreach ((array)explode("|", $_sortarray) as $_sort) {
        switch ($_sort) {
          case 'sort':
            $sort[] = 'orderBySort';
            break;
          case 'date':
            $sort[] = 'orderByNewdate';
            break;
          case 'name':
            $sort[] = 'orderByName';
            break;
          case 'id':
            $sort[] = 'orderById';
            break;
          case 'chapter':
            $sort[] = 'orderByChapter';
            break;
          case 'issue':
            $sort[] = 'orderByIssue';
            break;
          default:
            if ($_sort != false && $_sort != "sort") {
              $sort[] = $_sort;
            }
            break;
        }
      }
    }


    if (
      ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && (
        is_array($issueid)
          ? count(array_intersect($issueid, $this->rights["issues"]->getPrimaryKeys())) === count($issueid)
          : in_array($issueid, $this->rights["issues"]->getPrimaryKeys())
        ))) &&
      ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && (
        is_array($chapterid)
          ? count(array_intersect($chapterid, $this->rights["formats"]->getPrimaryKeys())) === count($chapterid)
          : in_array($chapterid, $this->rights["formats"]->getPrimaryKeys())

        )))
    ) {

      $q = $this->ContributionsQuery()
                ->filterByForissue($issueid)
                ->filterByForchapter($chapterid)
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                ;

        if ($count === true) return $q->count();

        foreach ($sort as $_key=>$_sort) {

          $numeric = false;
          if ($directions[$_key] == "nasc") {
            $directions[$_key] = "asc";
            $numeric = true;
          }
          if ($directions[$_key] == "ndesc") {
            $directions[$_key] = "desc";
            $numeric = true;
          }

          $direction = ($directions[$_key] == "asc" || $directions[$_key] == "desc")
                        ? $directions[$_key]
                        : "asc";

          switch ($_sort) {
            case 'orderBySort':
            case 'orderByNewdate':
            case 'orderByName':
            case 'orderById':
              $q = $q->$_sort($direction);
              break;
            case 'orderByChapter':
              $q = $q->useFormatsQuery('ChapterSortColumn')
                      ->withColumn('ChapterSortColumn.__sort__', 'chaptersort')
                    ->endUse()
                    ->orderBy('chaptersort', $direction);
              break;
            case 'orderByIssue':
              $q = $q->useIssuesQuery('IssueSortColumn')
                      ->withColumn('IssueSortColumn.__sort__', 'issuesort')
                    ->endUse()
                    ->orderBy('issuesort', $direction);
              break;
            default:
              $q = $q->withColumn($numeric === true ? 'CAST(SortColumn_'.$_sort.'._content as signed)': 'SortColumn_'.$_sort.'._content', 'sortcolumn_'.$_sort)
                    ->useDataQuery('SortColumn_'.$_sort)
                      ->filterByFortemplatefield($_sort)
                    ->endUse()
                    ->orderBy('sortcolumn_'.$_sort, $direction);
              break;
          }
        }

        $q =  $q->_if($offset)
                  ->offset((int)$offset)
                ->_endif()
                ->_if($limit)
                  ->limit((int)$limit)
                ->_endif();
        return $q;
      }
      else return false;
  }

  /**
   * returns all contributions matching string in the name
   *
   * @param string $string
   * @return ChildCollection\ContributionsQuery()
   * @author Urs Hofer
   */
  function searchContributions($string = "", $issueid = false, $chapterid = false, $status = false, $limit = false, $offset = false, $filterfield = false, $filtermode = "like", $sortmode = 'asc', $count = false, $templateid = false) {
    if ($issueid) {
      if ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && (
        is_array($issueid)
          ? count(array_intersect($issueid, $this->rights["issues"]->getPrimaryKeys())) === count($issueid)
          : in_array($issueid, $this->rights["issues"]->getPrimaryKeys())
        ))) {
          // OK
      }
      else {
        return false;
      }
    }
    elseif ($this->rights["issues"] !== true) {
      $issueid = $this->rights["issues"]->getPrimaryKeys();
    }

    if ($chapterid) {
      if ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && (
        is_array($chapterid)
          ? count(array_intersect($chapterid, $this->rights["formats"]->getPrimaryKeys())) === count($chapterid)
          : in_array($chapterid, $this->rights["formats"]->getPrimaryKeys())

        ))) {
          // OK
      } 
      else {
        return false;
      }
    }
    elseif ($this->rights["formats"] !== true) {
      $chapterid = $this->rights["formats"]->getPrimaryKeys();
    }
    
    
    
    
    /*
    // Checks: if issue id is set, only check for the rights for this issue
    if ($issueid) {
      if (!($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($issueid, $this->rights["issues"]->getPrimaryKeys()))))
        return false;
    }
    // Checks: if issue is not sent and user is regular, set issue to available primary keys
    elseif ($this->rights["issues"] !== true) {
      $issueid = $this->rights["issues"]->getPrimaryKeys();
    }

    // Checks: if chapter id is set, only check for the rights for this issue
    if ($chapterid) {
      if (!($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($chapterid, $this->rights["formats"]->getPrimaryKeys()))))
        return false;
    }
    // Checks: if chapter is not sent and user is regular, set chapters to available primary keys
    elseif ($this->rights["formats"] !== true) {
      $chapterid = $this->rights["formats"]->getPrimaryKeys();
    }
    */

    /**
     * Sort Mode
     *
     **/

    $sort = [];
    $directions = [];

    // Default:
    if ($sortmode == "asc" || $sortmode == "desc") {
      $directions[] = $sortmode;
      $sort[] = 'orderBySort';
    }
    else {
      list($_sortarray,$_direction) = explode(":", $sortmode);
      $directions = (array)explode("|", $_direction);
      foreach ((array)explode("|", $_sortarray) as $_sort) {
        switch ($_sort) {
          case 'sort':
            $sort[] = 'orderBySort';
            break;
          case 'date':
            $sort[] = 'orderByNewdate';
            break;
          case 'name':
            $sort[] = 'orderByName';
            break;
          case 'id':
            $sort[] = 'orderById';
            break;
          case 'chapter':
            $sort[] = 'orderByChapter';
            break;
          case 'issue':
            $sort[] = 'orderByIssue';
            break;
          default:
            if ($_sort != false && $_sort != "sort") {
              $sort[] = $_sort;
            }
            break;
        }
      }
    }

    /**
     * Initialize Query
     **/

    $q = $this->ContributionsQuery()
                ->_if($issueid)
                  ->filterByForissue($issueid)
                ->_endif()
                ->_if($chapterid)
                  ->filterByForchapter($chapterid)
                ->_endif()
                ->_if($status)
                  ->filterByStatus($status)
                ->_endif()
                ->_if($templateid)
                  ->filterByFortemplate($templateid)
                ->_endif()
                ->distinct()
                ->_and();
    /**
     * $string contains the query, divided by | multiple "or"
     * $filterfield: single or divided by |, either sort, id, date or field id
     * $filtermode: single or divided by |, default: like
     *
     * filterfields and filtermode need can be defined for each search term
     * if not, the default filtermode ("like") and filterfield (all fields) is
     * used for the search.
     *
     * ?query=Word1|Word2                     Searches for Word1 OR Word2 in all fields
     * ?query=Word1|Word2&filter=12:eq        Word1 matches field 12 OR Word2 matches everywhere
     * ?query=Word1+Word2&filter=1|2:eq+12    Word1 matches field 1 or 2 AND Word2 matches everywhere
     */


    // Filter Fields: If passed, only the selected fields are searched for a valoue
//    $filterfieldids = [];
    $filterby    = [];
    $filterbycol = [];
    $filtermodes = (array)explode("|", $filtermode);

    if ($filterfield) {
      foreach (explode('|', $filterfield) as $_key=>$f) {
        $_filter = in_array($filtermodes[$_key], ["lte","gte","lt","gt","eq", "like", "regexp", "hash"]) ? $filtermodes[$_key] : "like";
        switch ($f) {
          case 'sort':
            $filterby[] = [
              'method' => 'filterBySort',
              'column' => '_contributions.__sort__',
              'mode' => $_filter
            ];
            break;
          case 'id':
            $filterby[] = [
              'method' => 'filterById',
              'column' => '_contributions.id',
              'mode' => $_filter
            ];
            break;
          case 'date':
            $filterby[] = [
              'method' => 'filterByNewdate',
              'column' => '_contributions._newdate',
              'mode' => $_filter
            ];
            break;
          default:
            $filterby[] = [
              'method' => false,
              'column' => is_numeric($f) ? (int)$f : false,
              'mode' => $_filter
            ];
            //$filterfields[] = (int)$f;
            break;
        }

      }
    }

//    print_r(preg_split('/([\|\+])/', $string, -1, PREG_SPLIT_DELIM_CAPTURE));
//    die();
//    Array
//    (
//        [0] => Data
//        [1] => |
//        [2] => Test
//        [3] => +
//        [4] => Gutzi
//        [5] => |
//        [6] => Date
//    )

    $_key = 0;

    foreach (preg_split('/([\|\+])/', $string, -1, PREG_SPLIT_DELIM_CAPTURE) as $_s) {

      // Delimiter

      if ($_s == "|") {
        $q->_or();
        continue;
      }
      if ($_s == "+") {
        $q->_and();
        continue;
      }

      // Get Current Filter

      $_filter = $filterby[$_key]
                 ? $filterby[$_key]
                 : [
                    'method' => false,
                    'column' => false,
                    'mode'   => 'like'
                  ];

      // Standard Filter Methods: by date, by id, by sort

      if ($_filter['method']) {
        $q->_if($_filter['mode'] == "like")
                 ->{$_filter['method']}('%'.$_s.'%')
               ->_endif()
               ->_if($_filter['mode'] == "lt")
                 ->addUsingAlias($_filter['column'], (int)$_s, \Propel\Runtime\ActiveQuery\Criteria::LESS_THAN)
               ->_endif()
               ->_if($_filter['mode'] == "gt")
                 ->addUsingAlias($_filter['column'], (int)$_s, \Propel\Runtime\ActiveQuery\Criteria::GREATER_THAN)
               ->_endif()
               ->_if($_filter['mode'] == "lte")
                 ->{$_filter['method']}(array('max' => (int)$_s))
               ->_endif()
               ->_if($_filter['mode'] == "gte")
                 ->{$_filter['method']}(array('min' => (int)$_s))
               ->_endif()
               ->_if($_filter['mode'] == "eq")
                 ->{$_filter['method']}((int)$_s)
               ->_endif()
               ->_if($_filter['mode'] == "hash")
                  ->where($_filter['column'].' = ?', password_hash($_s, PASSWORD_DEFAULT))
               ->_endif()
               ->_if($_filter['mode'] == "regexp")
                 ->where($_filter['column'].' REGEXP ?', $this->clean_regexp($_s))
               ->_endif();
      }
      else {
        if (!$_filter['column']) {
          $q->_if($_filter['mode'] == "like")
                     ->where('_contributions._name LIKE ?', '%'.$_s.'%')
                   ->_endif()
                   ->_if($_filter['mode'] == "lt")
                     ->where('CAST(_contributions._name AS SIGNED) < ?', (int)$_s)
                   ->_endif()
                   ->_if($_filter['mode'] == "gt")
                     ->where('CAST(_contributions._name AS SIGNED) > ?', (int)$_s)
                   ->_endif()
                   ->_if($_filter['mode'] == "lte")
                     ->where('CAST(_contributions._name AS SIGNED) <= ?', (int)$_s)
                   ->_endif()
                   ->_if($_filter['mode'] == "gte")
                     ->where('CAST(_contributions._name AS SIGNED) >= ?', (int)$_s)
                   ->_endif()
                   ->_if($_filter['mode'] == "eq")
                     ->where('_contributions._name = ?', $_s)
                   ->_endif()
                   ->_if($_filter['mode'] == "hash")
                     ->where('_contributions._name = ?', password_hash($_s, PASSWORD_DEFAULT))
                   ->_endif()                   
                   ->_if($_filter['mode'] == "regexp")
                     ->where($_filter['column'].' REGEXP ?', $this->clean_regexp($_s))
                   ->_endif()
                   ->_or();
        }
        // Query Data as well
        /*$q = $q->useDataQuery('_data'.$_key)
                 ->_if($_filter['column'])
                   ->condition('_field', '_data'.$_key.'._fortemplatefield = ?', (int)$_filter['column'])
                 ->_endif()
                 ->_if($_filter['mode'] == "like")
                   ->condition('_data'.$_key, '_data'.$_key.'._content LIKE ?', '%'.$_s.'%')
                 ->_endif()
                 ->_if($_filter['mode'] == "lt")
                   ->condition('_data'.$_key, 'CAST(_data'.$_key.'._content AS SIGNED) < ?', (int)$_s)
                 ->_endif()
                 ->_if($_filter['mode'] == "gt")
                   ->condition('_data'.$_key, 'CAST(_data'.$_key.'._content AS SIGNED) > ?', (int)$_s)
                 ->_endif()
                 ->_if($_filter['mode'] == "lte")
                   ->condition('_data'.$_key, 'CAST(_data'.$_key.'._content AS SIGNED) <= ?', (int)$_s)
                 ->_endif()
                 ->_if($_filter['mode'] == "gte")
                   ->condition('_data'.$_key, 'CAST(_data'.$_key.'._content AS SIGNED) >= ?', (int)$_s)
                 ->_endif()
                 ->_if($_filter['mode'] == "eq")
                   ->condition('_data'.$_key, '_data'.$_key.'._content = ?', $_s)
                 ->_endif()
                 ->_if($_filter['column'])
                   ->where(array('_field', '_data'.$_key), 'and')
                 ->_else()
                   ->where(array('_data'.$_key))
                 ->_endif()
             ->endUse();*/
        if ($_filter['column']) {
          switch ($_filter['mode']) {
            case 'like':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND d._content LIKE ?))', [(int)$_filter['column'], '%'.$_s.'%']);             
              break;
            case 'lt':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND CAST(d._content AS SIGNED) < ?))', [(int)$_filter['column'], (int)$_s]);             
              break;
            case 'gt':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND CAST(d._content AS SIGNED) > ?))', [(int)$_filter['column'], (int)$_s]);             
              break;
            case 'lte':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND CAST(d._content AS SIGNED) <= ?))', [(int)$_filter['column'], (int)$_s]);             
              break;
            case 'gte':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND CAST(d._content AS SIGNED) >= ?))', [(int)$_filter['column'], (int)$_s]);             
              break;
            case 'eq':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND d._content = ?))', [(int)$_filter['column'], $_s]);             
              break;
            case 'hash':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND d._content = ?))', [(int)$_filter['column'], password_hash($_s, PASSWORD_DEFAULT)]);             
              break;
            case 'regexp':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._fortemplatefield = ? AND d._content REGEXP ?))', [(int)$_filter['column'], $this->clean_regexp($_s)]);             
              break;
          }
        }
        else {
          switch ($_filter['mode']) {
            case 'like':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._content LIKE ?))', '%'.$_s.'%');             
              break;
            case 'lt':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND CAST(d._content AS SIGNED) < ?))', (int)$_s);             
              break;
            case 'gt':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND CAST(d._content AS SIGNED) > ?))', (int)$_s);             
              break;
            case 'lte':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND CAST(d._content AS SIGNED) <= ?))', (int)$_s);             
              break;
            case 'gte':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND CAST(d._content AS SIGNED) >= ?))', (int)$_s);             
              break;
            case 'eq':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._content = ?))', $_s);             
              break;
            case 'hash':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._content = ?))', password_hash($_s, PASSWORD_DEFAULT));             
              break;              
            case 'regexp':
              $q->where('EXISTS (SELECT d._forcontribution FROM _data as d WHERE (_contributions.id = d._forcontribution AND d._content REGEXP ?))', $this->clean_regexp($_s));             
              break;
          }          
        }
      }

      $_key++;

      // This is an emergency break, it will stop after 20 queries
      if ($_key > 20) break;

    }
    // Return Counts Here

    if ($count === true) return $q->count();

    // Return Sorted Results

    foreach ($sort as $_key=>$_sort) {
      $numeric = false;
      if ($directions[$_key] == "nasc") {
        $directions[$_key] = "asc";
        $numeric = true;
      }
      if ($directions[$_key] == "ndesc") {
        $directions[$_key] = "desc";
        $numeric = true;
      }
      $direction = ($directions[$_key] == "asc" || $directions[$_key] == "desc")
                    ? $directions[$_key]
                    : "asc";
      switch ($_sort) {
        case 'orderBySort':
        case 'orderByNewdate':
        case 'orderByName':
        case 'orderById':
          $q = $q->$_sort($direction);
          break;
        case 'orderByChapter':
          $q = $q->useFormatsQuery('ChapterSortColumn')
                  ->withColumn('ChapterSortColumn.__sort__', 'chaptersort')
                ->endUse()
                ->orderBy('chaptersort', $direction);
          break;
        case 'orderByIssue':
          $q = $q->useIssuesQuery('IssueSortColumn')
                  ->withColumn('IssueSortColumn.__sort__', 'issuesort')
                ->endUse()
                ->orderBy('issuesort', $direction);
          break;
        default:
          $q = $q->withColumn($numeric === true ? 'CAST(SortColumn_'.$_sort.'._content as signed)': 'SortColumn_'.$_sort.'._content', 'sortcolumn_'.$_sort)
                ->useDataQuery('SortColumn_'.$_sort)
                  ->filterByFortemplatefield($_sort)
                ->endUse()
                ->orderBy('sortcolumn_'.$_sort, $direction);
          break;
      }
    }

    return $q->_if($offset)
              ->offset((int)$offset)
            ->_endif()
            ->_if($limit)
              ->limit((int)$limit)
            ->_endif();

  }

  /**
   * returns true or false depending on the access for a contribution
   *
   * @param contribution $_c
   * @return bool
   * @author Urs Hofer
   */

  function checkContributionAccess($_c) {
    if (
      (
        ($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($_c->getForissue(), $this->rights["issues"]->getPrimaryKeys()))) 
        &&
        ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($_c->getForchapter(), $this->rights["formats"]->getPrimaryKeys()))) 
        &&
        ($public === false || $_c->getStatus() != "Open")
      )
    )
    {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * returns Contribution object by id. If public == true, return the contribution only if the status is not open
   *
   * @param int $id
   * @param bool $checkstate
   * @return Childobject\Contribution()
   * @author Urs Hofer
   */
  function getContribution($id, $public = false, $overrule_user_rights = false) {
    if ($_c = $this
      ->ContributionsQuery()
      ->joinFormats()
      ->joinTemplatenames()
      ->joinIssues()
      ->joinData()
      ->joinContributionscache()
/*      ->joinWith('Contributions.Formats')
      ->joinWith('Contributions.Issues')
      ->joinWith('Contributions.Templatenames')
      ->joinWith('Formats.Books')

      // RefContrib: Loading Related Contributions - first, join Data Cross Table
      ->joinWith('Contributions.RDataContribution _ReferencedFields', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_ReferencedFields.RData ReferencedFields', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('ReferencedFields.Contributions RefContrib', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('ReferencedFields.Templates ReferencedFieldsTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)

          // RefContrib: Loading Related Tables
          ->joinWith('RefContrib.Data RefContribData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('RefContrib.Formats RefContribFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('RefContrib.Issues RefContribIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('RefContrib.Templatenames RefContribTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('RefContribData.Templates RefContribTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('RefContribFormats.Books RefContribBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*/

/*

        Alle mit Stern vorne bringen eigentlich nix... die andern schon


*            // Data Issue Relation
*            ->joinWith('RefContribData.RDataIssue __LinkedIssue', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('__LinkedIssue.RIssue RLinkedIssue', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            // Data Book Relation
*            ->joinWith('RefContribData.RDataBook __LinkedBook', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('__LinkedBook.RBook RLinkedBook', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            // Data Book Relation
*            ->joinWith('RefContribData.RDataFormat __LinkedFormat', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('__LinkedFormat.RFormat RLinkedFormat', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            // Data Book Relation
*            ->joinWith('RefContribData.RDataTemplate __LinkedTemplate', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('__LinkedTemplate.RTemplate RLinkedTemplate', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            // Data Contribution Relation
*            ->joinWith('RefContribData.RDataContribution __LinkedContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('__LinkedContribution.RContribution RLinkedContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                // Joining Contribution Data of a Linked Contribution
*                ->joinWith('RLinkedContribution.Data RLinkedContributionData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                ->joinWith('RLinkedContribution.Formats RLinkedContributionFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                ->joinWith('RLinkedContribution.Issues RLinkedContributionIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                ->joinWith('RLinkedContribution.Templatenames RLinkedContributionTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                ->joinWith('RLinkedContributionData.Templates RLinkedContributionsTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*                ->joinWith('RLinkedContributionFormats.Books RLinkedContributionsBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*
*
*          // LinkedData: Data to other Data Relation of this Contribution
*          ->joinWith('RefContribData.Contributions RefContribDataContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RefContribDataContribution.Formats RefContribDataContributionFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RefContribDataContribution.Issues RefContribDataContributionIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RefContribDataContribution.Templatenames RefContribDataContributionTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RefContribData.Templates RefContribDataContributionTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RefContribDataContributionFormats.Books RefContribDataContributionBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*
*          // One Step Nested
*          ->joinWith('RefContrib.RDataContribution __ReferencedFields', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('__ReferencedFields.RData RReferencedFields', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RReferencedFields.Contributions RRefContrib', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('RReferencedFields.Templates RReferencedFieldsTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContrib.Data RRefContribData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContrib.Formats RRefContribFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContrib.Issues RRefContribIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContrib.Templatenames RRefContribTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContribData.Templates RRefContribTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*            ->joinWith('RRefContribFormats.Books RRefContribBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*/


      // Data of this Contribution
/*      ->joinWith('Contributions.Data')
      ->joinWith('Data.Templates')
*/

/*          // LinkedData: Data to other Data Relation of this Contribution
*          ->joinWith('Data.RDataDataRelatedBySource _LinkedData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('_LinkedData.RDataRef LinkedData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedData.Contributions LinkedDataContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedDataContribution.Formats LinkedDataContributionsFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedDataContribution.Issues LinkedDataContributionsIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedDataContribution.Templatenames LinkedDataContributionsTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedData.Templates LinkedDataContributionsTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*          ->joinWith('LinkedDataContributionsFormats.Books LinkedDataContributionsBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*/

/*      // Data Issue Relation
      ->joinWith('Data.RDataIssue _LinkedIssue', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_LinkedIssue.RIssue LinkedIssue', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      // Data Book Relation
      ->joinWith('Data.RDataBook _LinkedBook', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_LinkedBook.RBook LinkedBook', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      // Data Book Relation
      ->joinWith('Data.RDataFormat _LinkedFormat', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_LinkedFormat.RFormat LinkedFormat', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      // Data Book Relation
      ->joinWith('Data.RDataTemplate _LinkedTemplate', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_LinkedTemplate.RTemplate LinkedTemplate', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      // Data Contribution Relation
      ->joinWith('Data.RDataContribution _LinkedContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
      ->joinWith('_LinkedContribution.RContribution LinkedContribution', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          // Joining Contribution Data of a Linked Contribution
          ->joinWith('LinkedContribution.Data LinkedContributionData', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('LinkedContribution.Formats LinkedContributionFormats', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('LinkedContribution.Issues LinkedContributionIssues', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('LinkedContribution.Templatenames LinkedContributionTemplatenames', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('LinkedContributionData.Templates LinkedContributionsTemplates', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
          ->joinWith('LinkedContributionFormats.Books LinkedContributionsBooks', \Propel\Runtime\ActiveQuery\Criteria::LEFT_JOIN)
*/
      ->findPk($id)) {
      if (
        (($this->rights["issues"] === true || (is_object($this->rights["issues"]) && in_array($_c->getForissue(), $this->rights["issues"]->getPrimaryKeys()))) &&
        ($this->rights["formats"] === true || (is_object($this->rights["formats"]) && in_array($_c->getForchapter(), $this->rights["formats"]->getPrimaryKeys()))) &&
        ($public === false || $_c->getStatus() != "Open"))
        ||
        ($overrule_user_rights === true && ($public === false || $_c->getStatus() != "Open"))
      ) {
        return $_c;
      }
      else {
        return false;
      }
    }
    else {
      return null;
    }
  }

  /**
   * returns all contributions with a certain template
   *
   * @param Childobject\Template() $template
   * @return collection contributions
   * @author Urs Hofer
   */
  function getContributionsByTemplate($template) {
    return $this->ContributionsQuery()->filterByTemplatenames($template);
  }

  /**
   * return all templatenames of a certain chapter
   *
   * @param Childobject\Chapter() $chapter
   * @return collection templatenames
   * @author Urs Hofer
   */
  function getTemplatenamesByFormats($chapter) {
    return $this->TemplatenamesQuery()->filterByFormats($chapter)->orderByName();
  }

  /**
   * adds a message into the log for the current user
   *
   * @param string $message
   * @return collection LogQuery
   * @author Urs Hofer
   */
  function addLog($type, $message, $ip) {


    $log = $this->LogQuery()
      ->filterByAgent($type)
      ->filterByConfigSys($message)
      ->limit(1)
      ->findOne();

    if (!$log) {
      $log = new \Log();
      $count = 0;
    }
    else {
      $count = $log->getSplit() + 1;
    }

    $log->setUser($this->currentUser->getId())
        ->setIp($ip)
        ->setAgent($type)
        ->setDate(time())
        ->setConfigSys($message)
        ->setSplit($count)
        ->save();
  }

  /**
   * returns a log entries by type and latest date, optionally filtered by a callback
   * which is applied on the __config__ field.
   *
   * @param string $type
   * @return collection LogQuery
   * @author Urs Hofer
   */
  function getRecentLog($type = 'get_contributions', $callback = false, $limit = 4) {
    if (!$this->currentUser) return false;
    // SELECT __config__, MAX(_date) as date FROM _log GROUP BY __config__ ORDER BY date DESC
    $log = $this->LogQuery()
         ->filterByAgent($type)
         ->filterByUser($this->currentUser->getId())
         ->select('__config__')
         ->withColumn('MAX(_log._date)', 'date')
         ->groupBy('_log.__config__')
         ->orderBy('date', 'desc')
         ->limit($limit);
    return $this->applyCallbackAndLimitToLog($log, $callback);
  }

  /**
   * returns a log entries by type and max count of usage, optionally filtered by a callback
   * which is applied on the __config__ field.
   *
   * @param string $type
   * @return collection LogQuery
   * @author Urs Hofer
   */
  function getFavouriteLog($type = 'get_contributions', $callback = false, $limit = 10) {
    if (!$this->currentUser) return false;

    //SELECT __config__, count(__config__) AS count FROM _log WHERE _agent ="get_contributions" GROUP BY __config__ ORDER BY count DESC
    $log = $this->LogQuery()
           ->filterByAgent($type)
             ->filterByUser($this->currentUser->getId())
           ->select('__config__')
           ->withColumn('MAX(_log.__split__)', 'count')
           ->groupBy('_log.__config__')
           ->orderBy('count', 'desc')
           ->limit($limit);
    return $this->applyCallbackAndLimitToLog($log, $callback);
  }

  /**
   * callback wrapper function applied to the logfile
   *
   * @param string $type
   * @return collection LogQuery
   * @author Urs Hofer
   */
  private function applyCallbackAndLimitToLog($log, $callback) {
    $retval = [];
    foreach ($log as $data) {
      if ($callback) {
        $data['__config__'] = $callback($data['__config__']);
        if ($data['__config__']) {
         $retval[] = $data;
        }
      }
      else $retval[] = $data;
    }
    return $retval;
  }


  /**
   * adds a book
   *
   * @param string $name
   * @return int or false
   * @author Urs Hofer
   */
  function addBook($name) {
    $last =  $this->BooksQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;

    $c = new \Books();
    $c->setName($name)
      ->setUserSysRef($this->currentUser)
      ->setSort($_newsort)
      ->save();
    return ($c ? $c->getId() : false);
  }

  /**
   * adds an issue
   *
   * @param string $name
   * @param int $forbook
   * @param string $status
   * @return int or false
   * @author Urs Hofer
   */
  function addIssue($name, $forbook, $status = 'open') {
    $last =  $this->IssuesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;

    $c = new \Issues();
    $c->setName($name)
      ->setForbook($forbook)
      ->setStatus($status)
      ->setUserSysRef($this->currentUser)
      ->setSort($_newsort)
      ->save();

    return ($c ? $c->getId() : false);
  }

  /**
   * sets the issue state to open
   *
   * @param int $id
   * @return void
   * @author Urs Hofer
   */
  function openIssue($id) {
    $this->getIssue($id)
         ->setStatus("open")
         ->save();
  }

  /**
   * sets the issue state to close
   *
   * @param int $id
   * @return void
   * @author Urs Hofer
   */
  function closeIssue($id) {
    $this->getIssue($id)
         ->setStatus("closed")
         ->save();
  }

  /**
   * adds a chapter
   *
   * @param string $name
   * @param int $forbook
   * @return int or false
   * @author Urs Hofer
   */
  function addChapter($name, $forbook) {
    $last =  $this->FormatsQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;

    $c = new \Formats();
    $c->setName($name)
      ->setForbook($forbook)
      ->setUserSysRef($this->currentUser)
      ->setSort($_newsort)
      ->save();

    return ($c ? $c->getId() : false);
  }

  /**
   * stores the sort order of an array of books
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortBook($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->BooksQuery()
        ->findPk($id)
        ->setSort($sort)
        ->save();
    }
  }

  /**
   * stores the sort order of an array of issues
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortIssue($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->IssuesQuery()
        ->findPk($id)
        ->setSort($sort)
        ->save();
    }
  }

  /**
   * stores the sort order of an array of chapters
   *
   * @param array $sortarray
   * @return void
   * @author Urs Hofer
   */
  function sortChapter($sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->FormatsQuery()
        ->findPk($id)
        ->setSort($sort)
        ->save();
    }
  }

  /**
   * renames a book
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameBook($id, $name) {
    $this->_clearCache($id, $this->getBook($id)->getName(), 'ForbookName');
    $this->getBook($id)
         ->setName($name)
         ->save();

  }

  /**
   * change rights of a book
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function rightsBook($id, $rights) {
    $b = $this->getBook($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }

  /**
   * change settingsBook of a book
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function settingsBook($id, $rights) {
    $b = $this->getBook($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
  }


  /**
   * renames an issue
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameIssue($id, $name) {
    $this->_clearCache($id, $this->getIssue($id)->getName(), 'ForissueName');    
    $this->getIssue($id)
         ->setName($name)
         ->save();
  }

  /**
   * change rights of a issue
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function rightsIssue($id, $rights) {
    $b = $this->getIssue($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }

  /**
   * change config of a issue
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function settingsIssue($id, $rights) {
    $b = $this->getIssue($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
  }

  /**
   * renames a chapter
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameChapter($id, $name) {
    $this->_clearCache($id, $this->getFormat($id)->getName(), 'ForchapterName');    
    $this->getFormat($id)
         ->setName($name)
         ->save();
  }

  /**
   * change rights of a chapter
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function rightsChapter($id, $rights) {
    $b = $this->getFormat($id);
    foreach($b->getRightss() as $f) {$b->removeRights($f);}

    // Cycle thru form values and store them
    foreach ($rights as $value) {
      $b->addRights($this->getRight($value["value"]));
    }
    $b->save();
  }

  /**
   * change rights of a chapter
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function settingsChapter($id, $rights) {
    $b = $this->getFormat($id);
    if ($b) {
      $b->setConfigSys($rights);
      $b->save();
    }
  }

  /**
   * deletes a book with all content and binaries
   *
   * @param int $id
   * @return void
   * @author Urs Hofer
   */
  function deleteBook($id) {
    $_book =  $this->getBook($id);
    if ($_book) {
      // Delete Caches
      $this->_clearCache($id, $_book->getName());
      // Update Contribution References
      $this->_clearReferencedObjects($_book);
      // Delete Binaries & References
      foreach ($this->IssuesQuery()->filterByForbook($id) as $issue) {
        $this->_clearReferencedObjects($issue);
        foreach ($this->ContributionsQuery()->filterByIssues($issue) as $contribution) {
            $this->deleteData($contribution);
            $this->_clearReferencedObjects($contribution);
        }
      }
      // Delete Chapter References
      foreach ($this->FormatsQuery()->filterByForbook($id) as $chapter) {
        $this->_clearReferencedObjects($chapter);
      }
      $_book->delete();
    }
  }

  /**
   * deletes a issue with all content and binaries
   *
   * @param int $id
   * @return void
   * @author Urs Hofer
   */
  function deleteIssue($id) {
    $_issue = $this->getIssue($id);
    if ($_issue) {
      // Delete Caches
      $this->_clearCache($id, $_issue->getName());
      // Delete Contribution References
      $this->_clearReferencedObjects($_issue);
      // Delete Binaries & References
      foreach ($this->ContributionsQuery()->filterByForissue($id) as $contribution) {
        $this->deleteData($contribution);
        $this->_clearReferencedObjects($contribution);
      }
      $_issue->delete();
      return true;
    }
    return false;
  }

  /**
   * deletes a chapter with all content and binaries
   *
   * @param int $id
   * @return void
   * @author Urs Hofer
   */
  function deleteChapter($id) {
    $_chapter = $this->getFormat($id);
    if ($_chapter) {
      // Delete Caches
      $this->_clearCache($id, $_chapter->getName());
      // Update Contribution References
      $this->_clearReferencedObjects($_chapter);
      // Delete Binaries & References
      foreach ($this->ContributionsQuery()->filterByForchapter($id) as $contribution) {
        $this->deleteData($contribution);
        $this->_clearReferencedObjects($contribution);
      }
      // Set Parentnode of dependent chapters to -1
      foreach ($this->getFormats()->filterByForbook($_chapter->getForbook()) as $f) {
        $_config = json_decode($f->getConfigSys());
        if ($_config->parentnode == $id) {
          $_config->parentnode = -1;
          $f->setConfigSys(json_encode($_config))->save();
        }
      }
      // Delete Chapter
      $_chapter->delete();
      return true;
    }
    return false;
  }

  /**
   * duplicates a book with all content
   *
   * @param int $id
   * @param string $suffix
   * @return void
   * @author Urs Hofer
   */
  function duplicateBook($id, $suffix = "Copy") {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }
    $new = $this->getBook($id)
                ->copy(true);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();
    /* Not necessary. Deep copy of books copy only direct affiliated data
    foreach ($this->IssuesQuery()->filterByForbook($new->getId()) as $issue) {
      foreach ($this->ContributionsQuery()->filterByIssues($issue) as $contribution) {
        $this->duplicateData($contribution);
      }
    }*/
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }

  /**
   * duplicates a issue with all content if deep is true
   *
   * @param int $id
   * @param string $suffix
   * @param bool $deep
   * @return void
   * @author Urs Hofer
   */
  function duplicateIssue($id, $suffix = "Copy", $deep = false) {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }

    $new = $this->getIssue($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();
    if ($deep === true) {
      foreach ($this->ContributionsQuery()->filterByForissue($new->getId()) as $contribution) {
        $this->duplicateData($contribution);
      }
    }
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }

  /**
   * duplicates a chapter with all content
   *
   * @param int $id
   * @param string $suffix
   * @return void
   * @author Urs Hofer
   */
  function duplicateChapter($id, $suffix = "Copy", $deep = false) {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }

    $new = $this->getFormat($id)
                ->copy($deep);
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();
    if ($deep === true) {
      foreach ($this->ContributionsQuery()->filterByForchapter($new->getId()) as $contribution) {
        $this->duplicateData($contribution);
      }
    }
    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }

  /**
   * adds a template (without any fields)
   *
   * @param string $name
   * @return int or false
   * @author Urs Hofer
   */
  function addTemplates($name) {
    $last =  $this->TemplatenamesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;

    $c = new \Templatenames();
    $c->setName($name)
      ->setSort($_newsort)
      ->save();
    return ($c ? $c->getId() : false);      
  }

  /**
   * renames a template
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameTemplates($id, $name) {
    $this->TemplatenamesQuery()
         ->findPk($id)
         ->setName($name)
         ->save();
  }

  /**
   * deletes a template and all contributions attached to it
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function deleteTemplates($id) {
    foreach ($this->ContributionsQuery()->filterByFortemplate($id) as $contribution) {
        $this->deleteData($contribution);
    }
    $this->TemplatenamesQuery()
         ->findPk($id)
         ->delete();
  }

  /**
   * duplicates a template
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function duplicateTemplates($id, $suffix = "Copy") {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }

    $new = $this->TemplatenamesQuery()
                ->findPk($id)
                ->copy();
    $new
      ->setName($new->getName() . "[".$suffix."]")
      ->save();

    /* Clone Affiliated Fields */

    foreach ($this->TemplatesQuery()->filterByFortemplate($id) as $f) {
      $clone = $f->copy();
      $clone
        ->setTemplatenames($new)
        ->save();
    }


    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }

  /**
   * renames a template
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function updateTemplates($id, $data) {
    $t = $this->TemplatenamesQuery()->findPk($id);
    // Clear all relations first
    foreach($t->getFormatss() as $f) {$t->removeFormats($f);}
    foreach($t->getBookss() as $f) {$t->removeBooks($f);}
    foreach($t->getRightss() as $f) {$t->removeRights($f);}

    // Reset Checkboxes first, since they are not passed
    // if switched of, only on values
    $t->setPublic(false);

    // Cycle thru form values and store them
    foreach ($data as $value) {
      if ($value["name"] == "Formats") {
        $t->addFormats($this->getFormat($value["value"]));
      }
      elseif ($value["name"] == "Books") {
        $t->addBooks($this->getBook($value["value"]));
      }
      elseif ($value["name"] == "Rights") {
        $t->addRights($this->getRight($value["value"]));
      }
      elseif ($value["name"] == "Public") {
        $t->setPublic(true);
        $this->defaultLogger->info("set public: true");
      }
      else {
        $t->{"set".$value["name"]}($value["value"]);
      }
    }
    $t->save();
  }


  /**
   * adds a field into a template
   *
   * @param int $fortemplate
   * @param string $name
   * @return int or false
   * @author Urs Hofer
   */
  function addTemplatefield($fortemplate, $name, $type = "Text") {
    $last =  $this->TemplatesQuery()
                  ->orderBySort('desc')
                  ->findOne();
    if ($last)
      $_newsort = $last->getSort()+1;
    else
      $_newsort = 0;

    $t = new \Templates();
    $t->setFieldname($name)
      ->setFieldtype($type)
      ->setFortemplate($fortemplate)
      ->setSort($_newsort)
      ->save();

    // Add the field to the contributions
    foreach ($this->ContributionsQuery()->filterByFortemplate($fortemplate) as $c) {
      $d = new \Data();
      $d->setContributions($c)
        ->setTemplates($t)
        ->setUserSysRef($this->currentUser)
        ->setSort($_newsort)
        ->save();
    }
    
    return ($t ? $t->getId() : false);
  }

  /**
   * deletes a field. if it's a binary field, deletes binaries first.
   * data related in contributions are deleted via mysql delete constraint
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function deleteTemplatefield($id) {
    $f = $this->TemplatesQuery()->findPk($id);
    if ($f->getFieldtype() == "Bild") {
      foreach ($this->DataQuery()->filterByFortemplatefield($f->getId()) as $d) {
        $this->FileModify($d->getId(), []);
      }
    }
    $f->delete();
  }

  /**
   * duplicates a field and all data in contributions recursively
   *
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function duplicateTemplatefield($id, $suffix = "Copy") {
    if (\ContributionsQuery::isVersioningEnabled()) {
      \ContributionsQuery::disableVersioning();
      \DataQuery::disableVersioning();
      $restoreVersioning = true;
    }
    else {
      $restoreVersioning = false;
    }

    $new = $this->TemplatesQuery()
                ->findPk($id)
                ->copy(true); // Deep Copy: We need it in the already stored documents
    $new
      ->setFieldname($new->getFieldname() . "[".$suffix."]")
      ->save();
    
    
    foreach ($new->getDatas() as $relData) {
      $relData->setContent("")->save();
    }

    if ($restoreVersioning) {
      \ContributionsQuery::enableVersioning();
      \DataQuery::enableVersioning();
    }
  }



  /**
   * renames a field in a template
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function renameTemplatefield($id, $name) {
    $this->TemplatesQuery()
         ->findPk($id)
         ->setFieldname($name)
         ->save();
  }

  /**
   * sorts the fields of a template
   *
   * @param int $id
   * @param string $name
   * @return void
   * @author Urs Hofer
   */
  function sortTemplatefield($fortemplate, $sortarray) {
    if (!is_array($sortarray))
      return false;
    foreach ($sortarray as $sort=>$id) {
      $this->TemplatesQuery()
        ->findPk($id)
        ->setSort($sort)
        ->save();
      $this->DataQuery()
        ->filterByFortemplatefield($id)
        ->update(array('Sort' => $sort));
    }
  }

  /**
   * updates the field settings
   *
   * @param int $id
   * @param array $data
   * @return void
   * @author Urs Hofer
   */
  function updateTemplatefield($id, $data) {
    $t = $this->TemplatesQuery()->findPk($id);
    /*
(
    [0] => Array
        (
            [name] => Fieldtype
            [value] =>
        )

    [1] => Array
        (
            [name] => ConfigSys
            [value] => {"lengthinfluence":[{"fieldname":2,"factor":"0"},{"fieldname":4,"factor":"0"},{"fieldname":1,"factor":"0"},{"fieldname":19,"factor":"0"},{"fieldname":5,"factor":"0"}],"history":false,"maxlines":false,"textlength":"10000","fullhistory":false,"rtfeditor":false,"codeeditor":true,"editorcolumns":[{"lines":"10","label":"Source"},{"lines":"10","label":"View"},{"lines":"10","label":"Translation"}],"arrayeditor":true}
        )

    [2] => Array
        (
            [name] => Helpdescription
            [value] => <table>
        )

    [3] => Array
        (
            [name] => Helpimage
            [value] =>
        )

)
    */

    // Cycle thru form values and store them
    foreach ($data as $value) {
      $t->{"set".$value["name"]}($value["value"]);
    }
    $t->save();
  }


  /**
   * duplicates the data of upload fields of a contribution
   *
   * @param array $ids
   * @param string $suffix
   * @return void
   * @author Urs Hofer
   */
  function duplicateData($contribution) {
    $private = !$contribution->getTemplatenames()->getPublic();
    foreach ($contribution->getDatas() as $field) {
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $olddata  = json_decode($field->getContent(), true);
        if (is_array($olddata)) {
          foreach ($olddata as $key=>$oldimage) {
              list($olddata[$key][1], $olddata[$key][2]) = $this->CopyFiles($oldimage[1], $oldimage[2], $private);
          }
          $field->setContent(json_encode($olddata))->save();
        }
      }
    }
  }

  /**
   * deletes the data of upload fields of a contribution
   *
   * @param array $ids
   * @param string $suffix
   * @return void
   * @author Urs Hofer
   */
  function deleteData($contribution) {
    foreach ($contribution->getDatas() as $field) {
      // Delete Images
      if ($field->getTemplates()->getFieldtype() == "Bild") {
        $this->FileModify($field->getId(), []);
      }
    }
  }

} // END class

?>
