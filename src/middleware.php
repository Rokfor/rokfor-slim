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
    '/rf/forgot',
    '/rf/proxy',
    '/rf/logout',
    '/rf/dashboard',
    '/rf/',
    '/rf'
  ];
  $route = $request->getAttribute('route', null);
  if ($route) {
    $current = $route->getPattern();
    if (!$request->isXhr() && !in_array($current, $settings)) {
      return $response->withRedirect('/rf/login');
    }
  }
  $response = $next($request, $response);
  return $response;
};

/**
 * Authentification Middleware
 * If something failed, redirect to entry page
 * 
 * based on slim-auth
 *
 * @author Urs Hofer
 */
try {
  $authentification = $container->get('slimAuthRedirectMiddleware');  
} catch (Exception $e) {
  $authentification = function ($request, $response, $next) {
    return $response->withRedirect($this->settings['unknow_space_redirect']);
  };
}


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
  try {
    $identity = $this->authenticator->getIdentity();    
  } catch (Exception $e) {
    $identity = null;
  }

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
  try {
    // Option Requests
  
    if ($request->isOptions()) {
      $response = $next($request, $response);
      return $response;      
    }
  
  
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
  }
  catch (Exception $e) {
    $r = $response->withHeader('Content-type', 'application/json')->withStatus(500);
    $r->getBody()->write(json_encode(["Error" => "application error"]));
    return $r;
   };
};

/**
 * Check for a redis cache entry. If there is one, send it.
 * Works only for GET Calls
 * Redis Cache is cleared on POST Calls. This is cleary not optimal,
 * since the cache is cleared on nearly most editing/backend calls.
 * But due to the fact that Rokfor works as a Api-First CMS for Websites,
 * Most website calls via API are cached after a editing process.
 * @author Urs Hofer
 */

$redis = function ($request, $response, $next) {
  if ($this->redis['redis'] && ($request->isPost() || $request->isGet())) {
    $qt = microtime(true);
      
    $apicall = substr($request->getUri()->getPath(), 0, 4) === "/api";
    $proxycall = substr($request->getUri()->getPath(), 0, 10) === "/api/proxy";

    // Call Cache on Get and Api Calls, But not on private file proxy calls
    if ($request->isGet() && $apicall && !$proxycall) {
      // Create Transaction Hash
      $hash = md5($request->getUri()->getPath().$request->getUri()->getQuery().serialize($request->getHeader('Authorization')));
      // Send Cache
      
      $redis_expiration = $this->redis['client']->get('expiration');
      
      if ($this->redis['client']->exists($hash) === 1 && ($redis_expiration == false || time() < $redis_expiration)) {
        $response->getBody()->write($this->redis['client']->get($hash));
        return $response
          ->withAddedHeader('X-Redis-Cache', 'true')
          ->withAddedHeader('X-Redis-Expiration', $redis_expiration ? date('r', $redis_expiration) : -1 )
          ->withAddedHeader('X-Redis-Time', (microtime(true) - $qt));
      }
      // Send Original
      else {
        $response = $next($request, $response);
        $this->redis['client']->set($hash, $response->getBody());
        return $response;
      }
    }

    // Clear Cache on Post or Backend Calls
    if ($request->isPost() || !$apicall) {
      $prefix = $this->redis['client']->getOptions()->__get('prefix')->getPrefix();
      $keys = $this->redis['client']->keys("*");
      $removed = 0;
      foreach ($keys as $key) {
        if (substr($key, 0, strlen($prefix)) == $prefix) {
          $key = substr($key, strlen($prefix));
          $this->redis['client']->del($key);
        }
      }
      $response = $next($request, $response);
      return $response;
    }
    
  }

  // Continue not cached.
  $response = $next($request, $response);
  return $response;
};


/**
 * Cors Options: Passed to all
 * 
 * Rokfor does not restrict the api to a certain domain. Probably this can be changed in the future
 * when the R/W api is ready
 *
 * @author Urs Hofer
 */
$app->add(function ($request, $response, $next) {
  $corsOptions = [];
  if ($request->isGet() || $request->isOptions()) {
    $corsOptions = [
      "origin"            => $this->settings['cors']['ro'],
      "maxAge"            => 1728000,
      "allowCredentials"  => true,
      "allowMethods"      => array("GET", "OPTIONS")
    ];
  }
  else {
    $corsOptions = [
      "origin"            => $this->settings['cors']['rw'],
      "maxAge"            => 1728000,
      "allowCredentials"  => true,
      "allowMethods"      => array("POST")
    ];
  }
  $cors = new \CorsSlim\CorsSlim($corsOptions);
  return $cors->__invoke($request, $response, $next);
});
