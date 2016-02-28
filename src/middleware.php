<?php

use Slim\Exception\NotFoundException;

/**
 * Trailing Slash Middleware
 * 
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */


$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        return $response->withRedirect((string)$uri, 301);
    }

    return $next($request, $response);
});

/**
 * IP Resolver Middleware
 * 
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */

$checkProxyHeaders = true;
$trustedProxies = ['10.0.0.1', '10.0.0.2'];
$app->add(new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));


/**
 * Settings Middleware
 * 
 * Stores translations and paths in template accessible values
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
  $this->view->offsetSet('translations', $this->translations);  
  $this->view->offsetSet('paths', $this->paths);  
  $this->view->offsetSet('fieldtypes', $this->fieldtypes);
  $response = $next($request, $response);
  return $response;
});

/**
 * Logging Middleware
 * 
 * writes the current route to logfile
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
  $route = $request->getAttribute('route', null);
  if ($route) {
    $this->get('logger')->info("Rokfor ".$route->getPattern());
  }
  $response = $next($request, $response);
  return $response;
});

/**
 * Ajax Check Middleware
 * 
 * compares the request mode and the settings.
 * throws a 404 page if a route is called via browser but not listed as browser route
 *
 * @author Urs Hofer
 */

$ajaxcheck = function ($request, $response, $next) {
  $settings = [        
    '/rf/login',
    '/rf/logout',
    '/rf/dashboard',
    '/rf/',
    '/rf'
  ];
  $route = $request->getAttribute('route', null);
  if ($route) {
    $current = $route->getPattern();
    if (!$request->isXhr() && !in_array($current, $settings)) 
      throw new NotFoundException($request, $response);
  }
  $response = $next($request, $response);
  return $response;
};

/**
 * Authentification Middleware
 * 
 * based on slim-auth
 *
 * @author Urs Hofer
 */

$authentification = $container->get('slimAuthRedirectMiddleware');

/**
 * CSRF Protection
 * 
 * based on slim-csrf.
 * additionally, adds the csrf data to the view. which makes it
 * easy to include in a template.
 *
 * @author Urs Hofer
 */

$csrf = function ($request, $response, $next) {
    $this->view->offsetSet('csrf', [
      'nameKey'   => $this->csrf->getTokenNameKey(),
      'valueKey'  => $this->csrf->getTokenValueKey(),
      'name'      => $request->getAttribute($this->csrf->getTokenNameKey()), 
      'value'     => $request->getAttribute($this->csrf->getTokenValueKey())
      ]);  
    $response = $next($request, $response);
    return $response;
};

/**
 * Set up Rokfor Database with correct user
 * 
 * based on the groups and fortemplate, forbooks and forissues n2n relations
 * stores the rights in $this->rights
 *
 * @author Urs Hofer
 */

$identificator = function ($request, $response, $next) {
  $identity = $this->authenticator->getIdentity();
  if ($identity) {
    if ($this->db->setUser($identity['id'])) {
      $this->view->offsetSet('__currentuser__', $this->db->getUser());
    }
    else {
      $route = $request->getAttribute('route', null);
      if ($route->getPattern() <> "/rf/login") {
        return $response->withRedirect('/rf/login');
      }
    }
  }
  $response = $next($request, $response);
  return $response;
};



/**
 * Check for read only key in header (Authorization: Bearer KEY) or as query param (?access_token=KEY)
 * 
 * Rokfor checks for read only keys in headers if somebody wants to access a 
 * resource via r/o api. In case of a public application like a website, r/o keys are public.
 * 
 * Never expose r/w keys to the public. Treat them like passwords. Only use them with a proxy server
 * if you need public write access to a Rokfor System.
 *
 * @author Urs Hofer
 */

$apiauth = function ($request, $response, $next) {
  $response = $response->withHeader('Content-type', 'application/json');
  $apikey = false;
  
  // Get Requests: R-O Keys

  if ($request->isGet()) {
    if ($request->getQueryParams()['access_token']) {
      $apikey = $request->getQueryParams()['access_token'];
    }
    else {
      $bearer = $request->getHeader('Authorization');
      if ($bearer[0]) {
        preg_match('/^Bearer (.*)/', $bearer[0], $bearer);
        $apikey = $bearer[1];
      }
    }
  }
  if ($apikey) {
    $u = $this->db->getUsers()
          ->filterByRoapikey($apikey)
          ->limit(1)
          ->findOne();
    if ($u) {
      $this->db->setUser($u->getId());
      $response = $next($request, $response);
      return $response;  
    }
    else $msg = "Wrong key supplied";
  }
  else $msg = "No key supplied";
  $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
  $r->getBody()->write(json_encode(["Error" => $msg]));
  return $r;
};
