<?php

use Slim\Exception\NotFoundException;

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
 * Ajax Check Middleware
 * 
 * compares the request mode and the settings.
 * throws a 404 page if a route is called via browser but not listed as browser route
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
  $settings = $this->get('settings')['browser'];
  $route = $request->getAttribute('route', null);
  if ($route) {
    $current = $route->getPattern();
    if (!$request->isXhr() && !in_array($current, $settings)) 
      throw new NotFoundException($request, $response);
  }
  $response = $next($request, $response);
  return $response;
});

/**
 * Set up Rokfor Database with correct user
 * 
 * based on the groups and fortemplate, forbooks and forissues n2n relations
 * stores the rights in $this->rights
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
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
 * Authentification Middleware
 * 
 * based on slim-auth
 *
 * @author Urs Hofer
 */

$app->add($container->get('slimAuthRedirectMiddleware'));

/**
 * CSRF Protection
 * 
 * based on slim-csrf.
 * additionally, adds the csrf data to the view. which makes it
 * easy to include in a template.
 *
 * @author Urs Hofer
 */

$app->add(function ($request, $response, $next) {
    $this->view->offsetSet('csrf', [
      'nameKey'   => $this->csrf->getTokenNameKey(),
      'valueKey'  => $this->csrf->getTokenValueKey(),
      'name'      => $request->getAttribute($this->csrf->getTokenNameKey()), 
      'value'     => $request->getAttribute($this->csrf->getTokenValueKey())
      ]);  
    $response = $next($request, $response);
    return $response;
});
$app->add($container->get('csrf'));
