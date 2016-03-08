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
   *  Additional query parameters: 
   *  - query=string
   *  - sort=[id|date|name:]asc|desc
   *  - limit=int
   *  - offset=int
   *  - data=[Fieldname|Fieldname|XX]
   */
  $this->options('/contributions/{issue:[0-9]*}/{chapter:[0-9]*}', 
    function ($request, $response, $args) {}
  )->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));
  $this->get('/contributions/{issue:[0-9]*}/{chapter:[0-9]*}', function ($request, $response, $args) {
    $j = [];
    $_fids = [];

    $c = $request->getQueryParams()['query']
          ? $this->db->searchContributions($request->getQueryParams()['query'], $args['issue'], $args['chapter'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset'])
          : $this->db->getContributions($args['issue'], $args['chapter'], $request->getQueryParams()['sort'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset']);
    if (is_object($c)) foreach ($c as $_c) {
      // Check for publish date.
      $_config = json_decode($_c->getConfigSys());
      if (is_object($_config) && $_config->lockdate > time()) {
        continue;
      }

      $_contribution = $_c->toArray(); 
      if ($request->getQueryParams()['data']) {
        // Populate Field Ids on the first call
        if (count($_fids) == 0) {
          foreach (explode('|', $request->getQueryParams()['data']) as $fieldname) {
            $_f = $this->db->getTemplatefields()
                           ->filterByFieldname($fieldname)
                           ->filterByFortemplate($_c->getFortemplate())
                           ->findOne();
            if (!$_f) {
              $errcode = 404;
              $newResponse = $response->withStatus($errcode);
              $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Population failed. Field unknown.'], JSON_CONSTANTS));
              return $newResponse;            
            }
            else $_fids[] = $_f->getId();
          }
        }
        $criteria = new \Propel\Runtime\ActiveQuery\Criteria();
        $criteria->add('_fortemplatefield', $_fids, \Propel\Runtime\ActiveQuery\Criteria::IN);  
        foreach ($_c->getDatas($criteria) as $field) {
          $_data = $this->helpers->prepareApiData($field);
          $_contribution['data'][$_data['template']['Fieldname']] = $_data;
        }
      }
      $j[] = $_contribution;
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
   */
  $this->options('/contribution/{id:[0-9]*}', 
    function ($request, $response, $args) {}
  )->add(\CorsSlim\CorsSlim::routeMiddleware($corsGetOptions));  
  $this->get('/contribution/{id:[0-9]*}', function ($request, $response, $args) {
    $j = [];
    $c = $this->db->getContribution($args['id']);
    if ($c && $c->getStatus()=="Close") {
      $criteria = new \Propel\Runtime\ActiveQuery\Criteria(); 
      $criteria->addAscendingOrderByColumn(__sort__); 
      foreach ($c->getDatas($criteria) as $field) {
        $_data = $this->helpers->prepareApiData($field);
        $d[$_data['template']['Fieldname']] = $_data;
      }
      $response->getBody()->write(json_encode([
        "contribution"              => $this->helpers->prepareApiContribution($c),
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