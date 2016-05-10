<?php

$app->group('/api', function () {
  /*
   * Pretty Print JSON
   */
  
    define('JSON_CONSTANTS', JSON_PRETTY_PRINT);

  /*  Contributions Access
   * 
   *  Issue and chapter is either an integer or a combination of values seperated 
   *  with a Hypen: i.e. x or x-x
   * 
   *  Additional query parameters: 
   *  - query=string
   *  - sort=[id|date|name|sort]:[asc|desc]
   *  - limit=int
   *  - offset=int
   *  - filter=[int|...]:[lt|gt|eq|like] (default operator: like)
   *  - data=[Fieldname|...]             (default: empty)
   *  - populate=true|false              (default: false)
   *  - verbose=true|false               (default: false)
   */
  $this->options('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', 
    function ($request, $response, $args) {}
  );
  
  $this->get('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', 
    function ($request, $response, $args) {
    $j = [];
    $_fids = [];
    if (stristr($args['issue'],'-')) {
      $args['issue'] = explode('-', $args['issue']);
    }
    if (stristr($args['chapter'],'-')) {
      $args['chapter'] = explode('-', $args['chapter']);
    }      
    $compact = $request->getQueryParams()['verbose'] == "true" ? false : true;

    $_limit  = $request->getQueryParams()['limit'] ? intval($request->getQueryParams()['limit']) : null;
    $_offset = $request->getQueryParams()['offset'] ? intval($request->getQueryParams()['offset']) : null;
    $_query  = $request->getQueryParams()['query'] ? $request->getQueryParams()['query'] : false;

    // Parse Query Strings...
    if ($_query == "date:now") {
      $_query = time();
    }
    
    list($filterfields, $filterclause) = explode(':',$request->getQueryParams()['filter']);
    $qt = microtime(true);
    $c = $_query
          ? $this->db->searchContributions($_query, $args['issue'], $args['chapter'], 'Close', $_limit, $_offset, $filterfields, $filterclause, $request->getQueryParams()['sort'])
          : $this->db->getContributions($args['issue'], $args['chapter'], $request->getQueryParams()['sort'], 'Close', $_limit,  $_offset);

    if (is_object($c)) {
      
      // Counting Max Objects without pages and limits
      $_count = $_query
          ? $this->db->searchContributions($_query, $args['issue'], $args['chapter'], 'Close', false, false, $filterfields, $filterclause, false, true)
          : $this->db->getContributions($args['issue'], $args['chapter'], false, 'Close', false, false, true);

      foreach ($c as $_c) {
        // Check for publish date.
        $_config = json_decode($_c->getConfigSys());
        if (is_object($_config) && $_config->lockdate > time()) {
          continue;
        }

        $_contribution["Contribution"]  = $this->helpers->prepareApiContribution($_c, $compact, $request); 
        $_contribution["Data"]          = $this->helpers->prepareApiContributionData($_c, $compact, $request);
        $j[] = $_contribution;
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
      if ($c && $c->getStatus()=="Close") {
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
  
})->add($redis)->add($apiauth);