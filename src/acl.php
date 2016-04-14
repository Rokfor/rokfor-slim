<?php

namespace Rokfor;

use Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
    public function __construct()
    {
        // Roles
        $this->addRole('guest');              // Not Logged in
        $this->addRole('user',  'guest');     // Regular User
        $this->addRole('admin', 'user');      // Administrator
        $this->addRole('root',  'admin');     // Super User

        // Rokfor Routes for the admin backend

        $_rf_routes = ['guest'=>[],'user'=>[],'admin'=>[],'root'=>[]];

        // Basic Permission for everybody: Login form
        $_rf_routes['guest'][] = ['/rf',                                                                    'GET'];
        $_rf_routes['guest'][] = ['/rf/login',                                                              ['GET','POST']];
                                                                                                            
        // Regular Users
        $_rf_routes['user'][] = ['/rf/logout',                                                              'GET'];
        $_rf_routes['user'][] = ['/rf/dashboard',                                                           'GET'];
        $_rf_routes['user'][] = ['/rf/menu',                                                                'GET'];
        $_rf_routes['user'][] = ['/rf/contributions/search',                                                ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}',         ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/contribution/{id:[0-9]*}',  'GET'];                                 
        $_rf_routes['user'][] = ['/rf/contribution/{action}/{id:[0-9]*}',                                   'POST'];
        $_rf_routes['user'][] = ['/rf/field/{id:[0-9]*}',                                                   'POST'];
        $_rf_routes['user'][] = ['/rf/profile',                                                             ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/exporters',                                                           ['GET','POST']];
                                                                                                            
        // Administrators (Like Users but with added structure and template management)
        $_rf_routes['admin'][] = ['/rf/structure',                                                          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/structure/{action:rename|rights}/{type}/{id:[0-9]*}',                'POST'];
        $_rf_routes['admin'][] = ['/rf/structure/{action:add|sort}/{type}[/{id:[0-9]*}]',                   'POST'];
        $_rf_routes['admin'][] = ['/rf/structure/{action:duplicate|delete|open|close}/{type}/{id:[0-9]*}',  'GET'];
        $_rf_routes['admin'][] = ['/rf/templates',                                                          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/{action:add|duplicate|delete}[/{id:[0-9]*}]',              ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/{action:rename|update}/{id:[0-9]*}',                       'POST'];
        $_rf_routes['admin'][] = ['/rf/templates/field/{action:add|duplicate|delete}/{id:[0-9]*}',          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/field/{action:rename|update|sort}/{id:[0-9]*}',            'POST'];

        // Root users (Like Admins but with added user management)
        $_rf_routes['root'][] = ['/rf/users',                                                               'GET'];
        $_rf_routes['root'][] = ['/rf/user[/{id:new|[0-9]*}]',                                              ['GET','POST']];
        $_rf_routes['root'][] = ['/rf/user/delete/{id:[0-9]*}',                                             'GET'];
        $_rf_routes['root'][] = ['/rf/group[/{id:new|[0-9]*}]',                                             ['GET','POST']];
        $_rf_routes['root'][] = ['/rf/group/delete/{id:[0-9]*}',                                            'GET'];
        
        // Routes for the JSON api. They are all guest routes since authentification 
        // is handled per request to keep the api restful.

        $_api_routes = ['guest'=>[]];
        $_api_routes['guest'][] = ['/api/contributions/{issue:[0-9]*}/{chapter:[0-9]*}',                    'GET'];
        $_api_routes['guest'][] = ['/api/contribution/{id:[0-9]*}',                                         'GET'];
        
        
        // Store Routes
        foreach ([$_api_routes, $_rf_routes] as $_routes) {
          foreach ($_routes as $_user=>$_rf_routes_per_user) {
            foreach ($_rf_routes_per_user as $_rf_route) {
              $this->addResource($_rf_route[0]); 
              $this->allow($_user,$_rf_route[0],$_rf_route[1]);
            }
          }
        }
        unset($_rf_routes, $_api_routes);

    }
}