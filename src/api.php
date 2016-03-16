<?php

$app->group('/api', function () {

  /*
   * Pretty Print JSON
   */
  
    define('JSON_CONSTANTS', JSON_PRETTY_PRINT);

  /**
   * Cors Options
   * 
   * Rokfor does not restrict the api to a certain domain. Probably this can be changed in the future
   * when the R/W api is ready
   *
   * @author Urs Hofer
   */
  $container = $this->getContainer();
  $corsGetOptions = [
    "origin" => $container->get('settings')['cors']['ro'],
    "maxAge" => 1728000,
    "allowCredentials" => true,
    "allowMethods" => array("GET")
  ];



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
   *  - filter=[int|...]:[lt|gt|eq|like] (default: like)
   *  - data=[Fieldname|...]             (default: empty)
   *  - populate=true|false              (default: false)
   *  - verbose=true|false               (default: false)
   */
  $this->options('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', 
    function ($request, $response, $args) {}
  )->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));
  $this->get('/contributions/{issue:[0-9-]*}/{chapter:[0-9-]*}', function ($request, $response, $args) {
    $j = [];
    $_fids = [];
    if (stristr($args['issue'],'-')) {
      $args['issue'] = explode('-', $args['issue']);
    }
    if (stristr($args['chapter'],'-')) {
      $args['chapter'] = explode('-', $args['chapter']);
    }      
    $compact = $request->getQueryParams()['verbose'] == "true" ? false : true;
    
    list($filterfields, $filterclause) = explode(':',$request->getQueryParams()['filter']);

    $c = $request->getQueryParams()['query']
          ? $this->db->searchContributions($request->getQueryParams()['query'], $args['issue'], $args['chapter'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset'], $filterfields, $filterclause, $request->getQueryParams()['sort'])
          : $this->db->getContributions($args['issue'], $args['chapter'], $request->getQueryParams()['sort'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset']);
    $_oldtemplate = false;
    if (is_object($c)) foreach ($c as $_c) {
      // Check for publish date.
      $_config = json_decode($_c->getConfigSys());
      if (is_object($_config) && $_config->lockdate > time()) {
        continue;
      }

      $_contribution = $this->helpers->prepareApiContribution($_c, $compact); 
      if ($request->getQueryParams()['data'] || $request->getQueryParams()['populate'] == "true") {
        // Reset fids on template change
        if ($_c->getFortemplate() <> $_oldtemplate) {
          $_fids = [];
        }
        // Populate Field Ids on the first call
        if (count($_fids) == 0) {
          if ($request->getQueryParams()['populate'] == "true") {
            $criteria = null;
          }
          else {
            foreach (explode('|', $request->getQueryParams()['data']) as $fieldname) {
              $_f = $this->db->getTemplatefields()
                             ->filterByFieldname($fieldname)
                             ->filterByFortemplate($_c->getFortemplate())
                             ->findOne();
              if ($_f) $_fids[] = $_f->getId();
            }
            $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
            $criteria->add('_fortemplatefield', $_fids, \Propel\Runtime\ActiveQuery\Criteria::IN);  
          }
        }
        foreach ($_c->getDatas($criteria) as $field) {
          $_contribution['data'][$field->getTemplates()->getFieldname()] = $this->helpers->prepareApiData($field, $compact);
        }
      }
      $j[] = $_contribution;
      $_oldtemplate = $_c->getFortemplate();
    }
    else {
      $errcode = 200;
      $newResponse = $response->withStatus($errcode);
      $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Request contains no content'], JSON_CONSTANTS));
      return $newResponse;
    }
    $response->getBody()->write(json_encode($j, JSON_CONSTANTS));
  })->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));

  /* Single Contribution
   * 
   *  - verbose=true|false
   */
  $this->options('/contribution/{id:[0-9]*}', 
    function ($request, $response, $args) {}
  )->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));  
  
  $this->get('/contribution/{id:[0-9]*}', function ($request, $response, $args) {
    $j = [];
    $compact = $request->getQueryParams()['verbose'] ? false : true;
    $c = $this->db->getContribution($args['id']);
    if ($c && $c->getStatus()=="Close") {
      $criteria = new \Propel\Runtime\ActiveQuery\Criteria(); 
      $criteria->addAscendingOrderByColumn(__sort__); 
      foreach ($c->getDatas($criteria) as $field) {
        $d[$field->getTemplates()->getFieldname()] = $this->helpers->prepareApiData($field, $compact);
      }
      $response->getBody()->write(json_encode([
        "contribution"              => $this->helpers->prepareApiContribution($c, $compact),
        "data"                      => $d
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
  })->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));



  
})->add($apiauth);