<?php

$app->group('/api', function () {

  define(JSON_CONSTANTS, JSON_PRETTY_PRINT);

  /*  Contributions Access
   * 
   *  Additional query parameters: 
   *  - query=string
   *  - sort=[id|date|name:]asc|desc
   *  - limit=int
   *  - offset=int
   */
   
  $this->get('/contributions/{issue:[0-9]*}/{chapter:[0-9]*}', function ($request, $response, $args) {
    $j = [];
    $c = $request->getQueryParams()['query']
          ? $this->db->searchContributions($request->getQueryParams()['query'], $args['issue'], $args['chapter'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset'])
          : $this->db->getContributions($args['issue'], $args['chapter'], $request->getQueryParams()['sort'], 'Close', $request->getQueryParams()['limit'], $request->getQueryParams()['offset']);
    if (is_object($c)) foreach ($c as $_c) {
      $j[]  = $_c->toArray();
    }
    else {
      $errcode = 204;
      $newResponse = $response->withStatus($errcode);
      $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Request contains no content'], JSON_CONSTANTS));
      return $newResponse;
    }
    $response->getBody()->write(json_encode($j, JSON_CONSTANTS));
  });  

  /* Single Contribution
   * 
   */
  
  $this->get('/contribution/{id:[0-9]*}', function ($request, $response, $args) {
    $j = [];
    $c = $this->db->getContribution($args['id']);
    if ($c && $c->getStatus()=="Close") {
      $criteria = new \Propel\Runtime\ActiveQuery\Criteria(); 
      $criteria->addAscendingOrderByColumn(__sort__); 
      foreach ($c->getDatas($criteria) as $field) {
        $t = $field->getTemplates();
        $_content = $field->getIsjson() ? json_decode($field->getContent()) : $field->getContent();
        if ($t->getFieldtype() == "Bild") {
          $_protocol = stristr($_SERVER['SERVER_PROTOCOL'], 'HTTPS') ? 'https://' : 'http://';
          foreach ($_content as &$_row) {
            $_row[1] = $_protocol.$_SERVER['HTTP_HOST'].$this->paths['web'].$_row[1];
          }
        }
        $d[$t->getFieldname()] = [
            "template"  => [
                  "Id"               => $t->getId(),
                  "Fortemplate"      => $t->getFortemplate(),
                  "Fieldname"        => $t->getFieldname(),
                  "Fieldtype"        => $t->getFieldtype(),
                  "ConfigSys"        => json_decode($t->getConfigSys())
            ],
            "field"     => [
                  "Id"               => $field->getId(),
                  "Forcontribution"  => $field->getForcontribution(),
                  "Fortemplatefield" => $field->getFortemplatefield(),
                  "Content"          => $_content,
                  "Isjson"           => $field->getIsjson()
                ]
          ];
      }


      $response->getBody()->write(json_encode([
        "contribution"              => [
          "Id"                      => $c->getId(),
          "Fortemplate"             => $c->getFortemplate(),
          "Forissue"                => $c->getForissue(),
          "Name"                    => $c->getName(),
          "Status"                  => $c->getStatus(),
          "Newdate"                 => $c->getNewdate(),
          "Moddate"                 => $c->getModdate(),
          "Forchapter"              => $c->getForchapter()
        ],
        "data"                      => $d
      ], JSON_CONSTANTS));
    }
    else {
      $errcode = 404;
      $newResponse = $response->withStatus($errcode);
      $newResponse->getBody()->write(json_encode(['code'=>$errcode, 'message'=>'Element not found'], JSON_CONSTANTS));
      return $newResponse;
    }
  });  



  
})->add($apiauth);