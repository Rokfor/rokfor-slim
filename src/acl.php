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

        // Everybody: Login form
        $_rf_routes['guest'][] = ['/rf',                                                                    'GET'];
        $_rf_routes['guest'][] = ['/rf/login',                                                              ['GET','POST']];
        $_rf_routes['guest'][] = ['/rf/forgot',                                                             ['GET','POST']];

        // Regular Users: Backend functions, File Proxy, Profile and Exporters
        $_rf_routes['user'][] = ['/rf/logout',                                                              'GET'];
        $_rf_routes['user'][] = ['/rf/dashboard',                                                           'GET'];
        $_rf_routes['user'][] = ['/rf/menu',                                                                'GET'];
        $_rf_routes['user'][] = ['/rf/contributions/search',                                                ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}[/{page:[0-9]*}]',         ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/contribution/{id:[0-9]*}',  'GET'];
        $_rf_routes['user'][] = ['/rf/contribution/{action}/{id:[0-9]*}',                                   ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/field/{id:[0-9]*}',                                                   'POST'];
        $_rf_routes['user'][] = ['/rf/profile',                                                             ['GET','POST']];
        $_rf_routes['user'][] = ['/rf/exporters[/{id:[0-9]*}[/{mode}/{sub:[0-9]*}]]',                       ['GET','POST']];
        //$_rf_routes['user'][] = ['/rf/proxy',                                                               'GET'];


        // Administrators: Structure and template management
        $_rf_routes['admin'][] = ['/rf/structure',                                                          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/structure/{action:rename|rights|settings}/{type}/{id:[0-9]*}',       'POST'];
        $_rf_routes['admin'][] = ['/rf/structure/{action:add|sort}/{type}[/{id:[0-9]*}]',                   'POST'];
        $_rf_routes['admin'][] = ['/rf/structure/{action:duplicate|delete|open|close}/{type}/{id:[0-9]*}',  'GET'];
        $_rf_routes['admin'][] = ['/rf/templates',                                                          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/{action:add|duplicate|delete}[/{id:[0-9]*}]',              ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/{action:rename|update}/{id:[0-9]*}',                       'POST'];
        $_rf_routes['admin'][] = ['/rf/templates/field/{action:add|duplicate|delete}/{id:[0-9]*}',          ['GET','POST']];
        $_rf_routes['admin'][] = ['/rf/templates/field/{action:rename|update|sort}/{id:[0-9]*}',            'POST'];

        // Root users: User management
        $_rf_routes['root'][] = ['/rf/users',                                                               'GET'];
        $_rf_routes['root'][] = ['/rf/user[/{id:new|[0-9]*}]',                                              ['GET','POST']];
        $_rf_routes['root'][] = ['/rf/user/delete/{id:[0-9]*}',                                             'GET'];
        $_rf_routes['root'][] = ['/rf/group[/{id:new|[0-9]*}]',                                             ['GET','POST']];
        $_rf_routes['root'][] = ['/rf/group/delete/{id:[0-9]*}',                                            'GET'];
        $_rf_routes['root'][] = ['/rf/routehooks[/{id:[0-9]*}]',                                            ['GET','POST']];
        $_rf_routes['root'][] = ['/rf/batchhooks[/{id:[0-9]*}]',                                            ['GET','POST']];


        // Routes for the JSON api. They are all guest routes since authentification
        // is handled per request to keep the api restful.

        $_api_routes = ['guest'=>[]];
        $_api_routes['guest'][] = ['/api/login',                                                            'POST'];
        $_api_routes['guest'][] = ['/api/books[/{id:[0-9]*}]',                                              'GET'];
        $_api_routes['guest'][] = ['/api/{action:issues|chapters}[/{id:[0-9]*}]',                           'GET'];
        $_api_routes['guest'][] = ['/api/{action:issue|chapter}/{id:[0-9]*}',                               ['POST', 'DEL']];
        $_api_routes['guest'][] = ['/api/{type:issue|chapter}',                                             'PUT'];
        $_api_routes['guest'][] = ['/api/contribution',                                                     'PUT'];
        $_api_routes['guest'][] = ['/api/contribution/{id:[0-9]*}',                                         ['GET', 'POST', 'DEL']];
        $_api_routes['guest'][] = ['/api/contributions/{issue:[0-9]*}/{chapter:[0-9]*}',                    'GET'];
        //$_api_routes['guest'][] = ['/api/proxy/{id:[0-9]*}/{file}',                                         'GET'];
        $_api_routes['guest'][] = ['/api/users',                                                            'GET'];
        $_api_routes['guest'][] = ['/asset/{id:[0-9]*}/{field:[0-9]*}/{file:.+}',                           'GET'];
        $_api_routes['guest'][] = ['/api/exporter/{id:[0-9]*}',                                             ['GET', 'POST']];
        $_api_routes['guest'][] = ['/api/exporter',                                                         ['GET', 'POST']];

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
