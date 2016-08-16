<?php

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

$app->group('/api', function () {
  /*
   * Pretty Print JSON
   */
  
//    define('JSON_CONSTANTS', JSON_PRETTY_PRINT);
    define('JSON_CONSTANTS', 0);

  /*  Contributions Access
   * 
   *  Issue and chapter is either an integer or a combination of values seperated 
   *  with a Hypen: i.e. x or x-x
   * 
   *  Additional query parameters: 
   *  - query=string
   *  - sort=[id|date|name|sort or chapter or issue or fieldname]:[asc|desc]
   *  - limit=int
   *  - offset=int
   *  - filter=[int|...]:[lt|gt|eq|like] (default operator: like)
   *  - data=[Fieldname|...]             (default: empty)
   *  - populate=true|false              (default: false)
   *  - verbose=true|false               (default: false)
   *  - template=id                      (default: false)
   *  - status=draft|published|both      (default: published)
   */
  $this->options('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', 
    function ($request, $response, $args) {}
  );
  
  $this->get('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', 
    function ($request, $response, $args) {
    $j = [];
    $_fids = [];
    $_cache_expiration = false;
    if (stristr($args['issue'],'-')) {
      $args['issue'] = explode('-', $args['issue']);
    }
    if (stristr($args['chapter'],'-')) {
      $args['chapter'] = explode('-', $args['chapter']);
    }      

    $compact = $request->getQueryParams()['verbose'] == "true" ? false : true;
    $_limit    = isset($request->getQueryParams()['limit']) ? intval($request->getQueryParams()['limit']) : null;
    $_offset   = isset($request->getQueryParams()['offset']) ? intval($request->getQueryParams()['offset']) : null;
    $_query    = isset($request->getQueryParams()['query']) ? $request->getQueryParams()['query'] : false;
    $_template = isset($request->getQueryParams()['template']) ? (int)$request->getQueryParams()['template'] : false;
    
    // Translate $_status to Rokfor Standards
    $_status   = 'Close';
    switch (strtolower($request->getQueryParams()['status'])) {
      case 'draft':
        $_status = 'Draft';
        break;
      case 'both':
        $_status = ['Draft', 'Close'];
        break;
      default:
        $_status = 'Close';
        break;
    }

    // Parse Query Strings...
    if ($_query == "date:now") {
      $_query = time();
    }
    
    list($filterfields, $filterclause) = explode(':',$request->getQueryParams()['filter']);
    $qt = microtime(true);
    $c = $_query !== false
          ? $this->db->searchContributions($_query, $args['issue'], $args['chapter'], $_status, $_limit, $_offset, $filterfields, $filterclause, $request->getQueryParams()['sort'], false, $_template)
          : $this->db->getContributions($args['issue'], $args['chapter'], $request->getQueryParams()['sort'], $_status, $_limit,  $_offset, false, $_template);

    if (is_object($c)) {
      
      // Counting Max Objects without pages and limits
      $_count = $_query !== false
          ? $this->db->searchContributions($_query, $args['issue'], $args['chapter'], $_status, false, false, $filterfields, $filterclause, false, true, $_template)
          : $this->db->getContributions($args['issue'], $args['chapter'], false, $_status, false, false, true, $_template);

      foreach ($c as $_c) {
        // Check for publish date.
        $_config = json_decode($_c->getConfigSys());
        if (is_object($_config) && $_config->lockdate > time()) {
          if ($_config->lockdate < $_cache_expiration || $_cache_expiration === false) {
            $_cache_expiration = $_config->lockdate;
          }
          continue;
        }

        $_contribution["Contribution"]  = $this->helpers->prepareApiContribution($_c, $compact, $request); 
        $_contribution["Data"]          = $this->helpers->prepareApiContributionData($_c, $compact, $request);
        $j[] = $_contribution;
      }
      if ($this->get('redis')['client']) {
        $this->get('redis')['client']->set('expiration', $_cache_expiration);
      }
      $response->getBody()->write(
        json_encode(
                    array("Documents" => $j, 
                          "NumFound"  => $_count, 
                          "Limit"     => count($c), 
                          "Offset"    =>  $_offset,
                          "QueryTime" => (microtime(true) - $qt),
                          "Hash"      => md5(serialize($j))
                    ), 
                    JSON_CONSTANTS
                   )
      );
    }
    else {
      $errcode = 200;
      $newResponse = $response->withStatus($errcode);
      $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Request contains no content'], JSON_CONSTANTS));
      return $newResponse;
    }
  }
  );

  /* Single Contribution
   * 
   *  - verbose=true|false
   */
  $this->options('/contribution/{id:[0-9]*}', 
    function ($request, $response, $args) {}
  );  
  
  $this->get('/contribution/{id:[0-9]*}', 
    function ($request, $response, $args) {
      $j = [];
      $qt = microtime(true);
      $compact = $request->getQueryParams()['verbose'] ? false : true;
      $c = $this->db->getContribution($args['id']);
      if ($c && ($c->getStatus()=="Close" || $c->getStatus()=="Draft")) {
        $response->getBody()->write(json_encode([
          "Contribution"              => $this->helpers->prepareApiContribution($c, $compact),
          "Data"                      => $this->helpers->prepareApiContributionData($c, $compact),
          "QueryTime"                 => (microtime(true) - $qt),
          "Hash"                      => md5(serialize($j))
        ], JSON_CONSTANTS));
      }
      else if ($c === false) {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'No access to Element'], JSON_CONSTANTS));
        return $newResponse;      
      }
      else {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Element not found'], JSON_CONSTANTS));
        return $newResponse;
      }
    }
  );

  /* Books
   * 
   *  - populate=true|false              (default: false)
   *  - verbose=true|false               (default: false)
   *  - data=[Fieldname|...]             (default: empty)
   */
  $this->options('/books[/{id:[0-9]*}]', 
    function ($request, $response, $args) {}
  );  
  
  $this->get('/books[/{id:[0-9]*}]', 
    function ($request, $response, $args) {  
      $qt = microtime(true);
      $b = $this->db->getStructure("", $args['id']);
      $compact = $request->getQueryParams()['verbose'] == "true" ? false : true;
      
      if ($b) {
        $j = [];
        foreach ($b as $_book) {
          $_chapters = [];
          $_issues = [];
          foreach ($_book["chapters"] as $_chapter) {
             $_chapters[] = $this->helpers->prepareApiStructureInfo($_chapter["chapter"], true, $compact, $request);
          }
          foreach ($_book["issues"] as $_issue) {
            $_issues[] = $this->helpers->prepareApiStructureInfo($_issue["issue"], true, $compact, $request);
          }       
          $j[] = array_merge($this->helpers->prepareApiStructureInfo($_book["book"], true, $compact, $request), ["Chapters" => $_chapters, "Issues" => $_issues]);
        }
        $response->getBody()->write(json_encode([
          "Books"                     => $j,
          "QueryTime"                 => (microtime(true) - $qt),
          "Hash"                      => md5(serialize($j))
        ], JSON_CONSTANTS));
      }
      else if ($b === false) {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'No access to Book'], JSON_CONSTANTS));
        return $newResponse;      
      }
      else {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Book not found'], JSON_CONSTANTS));
        return $newResponse;
      }
    }
  );

  /* Issues & Chapters
   * 
   *  - populate=true|false              (default: false)
   *  - verbose=true|false               (default: false)
   *  - data=[Fieldname|...]             (default: empty)
   */
  $this->options('/{action:issues|chapters}[/{id:[0-9]*}]', 
    function ($request, $response, $args) {}
  );  
  
  $this->get('/{action:issues|chapters}[/{id:[0-9]*}]', 
    function ($request, $response, $args) {  
      
      // Actions
      $funcname = 'getStructureBy'.ucfirst($args['action']);
      
      $qt = microtime(true);
      $i = $this->db->$funcname($args['id']);
      $compact = $request->getQueryParams()['verbose'] == "true" ? false : true;
      
      if ($i) {
        $j = [];
        foreach ($i as $_issue) {
          $j[] = $this->helpers->prepareApiStructureInfo($_issue, true, $compact, $request);
        }
        $response->getBody()->write(json_encode([
          ucfirst($args['action'])    => $j,
          "QueryTime"                 => (microtime(true) - $qt),
          "Hash"                      => md5(serialize($j))
        ], JSON_CONSTANTS));
      }
      else if ($i === false) {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'No access to '.ucfirst($args['action'])], JSON_CONSTANTS));
        return $newResponse;      
      }
      else {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>ucfirst($args['action']).' not found'], JSON_CONSTANTS));
        return $newResponse;
      }
    }
  );
  
  
  /* Binary Proxy
   * 
   * 
   */
  $this->options('/proxy/{id:[0-9]*}/{file}', 
    function ($request, $response, $args) {}
  );  
  
  $this->get('/proxy/{id:[0-9]*}/{file}', 
    function ($request, $response, $args) {  
      $c = $this->db->getContribution($args['id']);
      if ($c && ($c->getStatus()=="Close" || $c->getStatus()=="Draft")) {
        $url = base64_decode($args['file']);
        if ($url) {
          $this->get('logger')->info("DECODING: ".$url);
          return $this->db->proxy($url, $response);
        }
        else {
          $r = $response->withHeader('Content-type', 'application/json');
          $r->getBody()->write(json_encode(['error' => "404", 'message' => "File not found"]));
          return $r;
        }
      }
      else if ($c === false) {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'No access to Element'], JSON_CONSTANTS));
        return $newResponse;      
      }
      else {
        $errcode = 404;
        $newResponse = $response->withStatus($errcode);
        $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Element not found'], JSON_CONSTANTS));
        return $newResponse;
      }      
    }
  );      
    
  /* Login
   * Required for R/W Access. Login with username and R/W Key
   * Returns a JWT Token for further usage 
   *
   */
  
  $this->post('/login', 
    function ($request, $response, $args) {
      
      $u = $this->db->getUsers()
            ->filterByRwapikey($request->getParsedBody()['apikey'])
            ->filterByUsername($request->getParsedBody()['username'])
            ->limit(1)
            ->findOne();        
      if ($u) {
        $this->db->setUser($u->getId());
        $this->db->addLog('post_api', 'POST' , $request->getAttribute('ip_address'));
        $signer = new Sha256();
        $token = (new Builder())->setIssuer($_SERVER['HTTP_HOST'])    // Configures the issuer (iss claim)
                                ->setAudience($_SERVER['HTTP_HOST'])  // Configures the audience (aud claim)
                                ->setId(uniqid('rf', true), true)     // Configures the id (jti claim), replicating as a header item
                                ->setIssuedAt(time())                 // Configures the time that the token was issue (iat claim)
                                ->setNotBefore(time() + 60)           // Configures the time that the token can be used (nbf claim)
                                ->setExpiration(time() + 1800)        // Configures the expiration time of the token (nbf claim)
                                ->set('uid', $u->getId())             // Configures a new claim, called "uid"
                                ->sign($signer,  $u->getRwapikey()) // creates a signature using "testing" as key
                                ->getToken();                         // Retrieves the generated token
        $r = $response->withHeader('Content-type', 'application/json');
        $r->getBody()->write(json_encode((string)$token));
        return $r;
      }        
      else {
        $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
        $r->getBody()->write(json_encode(["Error" => "Wrong key supplied"]));
        return $r;
      }
    }
  );
    
  /* Put Contribution
   * Adding a contribution
   * 
   *
   */
  
  $this->put('/contribution', 
    function ($request, $response, $args) {
      $r = $response->withHeader('Content-type', 'application/json');

      // Payload:
      
      if ($data = json_decode($request->getBody())) {
        $_error = false;
        if (!is_int($data->Template))
          $_error = 'Template Id missing or not an integer value.';
        if (!is_int($data->Chapter))
          $_error = 'Chapter Id missing or not an integer value.';
        if (!is_int($data->Issue))
          $_error = 'Issue Id missing or not an integer value.';
        if (!is_string($data->Name))
          $_error = 'Contribution Name missing or not a string.';

        if ($_error === false) {
          $i = $this->db->getIssue($data->Issue);
          $f = $this->db->getFormat($data->Chapter);
          $c = false;
          $_error = false;
          if (!$_error && !$i) {
            $_error = "Issue does not exist.";
          }
          if (!$_error && !$f) {
            $_error = "Chapter does not exist.";
          }          
          if (!$_error && $i->getForbook() !== $f->getForbook()) {
            $_error = "Issue and chapter are not from the same book.";
          }          

          if (!$_error) {
            $template_ok = false;
            foreach ($this->db->getTemplates($f) as $allowedTemplate) {
              if ($allowedTemplate["id"] === $data->Template) {
                $template_ok = true;
              }
            }
            if ($template_ok === false) {
              $_error = "Template id not valid or not allowed within this chapter or issue.";
            }
          }
          if ($_error === false) {
            $c = $this->db->NewContribution($i, $f, $data->Template, $data->Name);

            // Store 
            if ($c !== false && gettype($c) == "object") {
              $r->getBody()->write(json_encode(["Id" => $c->getId()]));
            }
            else {
              $_error = "Error creating contribution.";
            }
          }
        }
      }
      else {
        $_error = "Body is not a valid json string.";
      }
      if ($_error) {
        $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
        $r->getBody()->write(json_encode(["Error" => $_error]));
      }
      return $r;
    }
  );   
  
  /* Post Contribution
   * Storing Data in a contribution with id :id
   * 
   * {meta:{string:name, int:templateid}, data:{field:value, field:value...}, status: "published|open|draft"}
   * 
   * 
   *
   */
  
  $this->post('/contribution/{id:[0-9]*}', 
    function ($request, $response, $args) {
      $r = $response->withHeader('Content-type', 'application/json');
      $r->getBody()->write(json_encode('ok'));
      return $r;
    }
  );      

  
  
})->add($redis)->add($apiauth);