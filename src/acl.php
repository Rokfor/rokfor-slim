<?

namespace Rokfor;

use Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
    public function __construct()
    {
        // Role overview
        
        $this->addRole('guest');              // Not Logged in
        $this->addRole('user',  'guest');     // Regular User
        $this->addRole('admin', 'user');      // Administrator
        $this->addRole('root',  'admin');     // Super User

        // Application Routes
        
        $this->addResource('/rf');  
        $this->addResource('/rf/');  
        $this->addResource('/rf/login');  
        $this->addResource('/rf/logout');
        $this->addResource('/rf/dashboard');
        $this->addResource('/rf/profile');
        $this->addResource('/rf/menu');
        $this->addResource('/rf/users');
        $this->addResource('/rf/user[/{id:new|[0-9]*}]');
        $this->addResource('/rf/user/delete/{id:[0-9]*}');

        $this->addResource('/rf/group[/{id:new|[0-9]*}]');
        $this->addResource('/rf/group/delete/{id:[0-9]*}');

        $this->addResource('/rf/contributions/search');
        $this->addResource('/rf/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}');

        $this->addResource('/rf/contribution');
        $this->addResource('/rf/contribution/{id:[0-9]*}');
        $this->addResource('/rf/contribution/{action}/{id:[0-9]*}');

        $this->addResource('/rf/field/{id:[0-9]*}');

        $this->addResource('/rf/structure');
        $this->addResource('/rf/structure/{action:rename|rights}/{type}/{id:[0-9]*}');
        $this->addResource('/rf/structure/{action:add|sort}/{type}[/{id:[0-9]*}]');
        $this->addResource('/rf/structure/{action:duplicate|delete|open|close}/{type}/{id:[0-9]*}');
                
        $this->addResource('/rf/templates');
        $this->addResource('/rf/templates/{action:add|duplicate|delete}[/{id:[0-9]*}]');
        $this->addResource('/rf/templates/{action:rename|update}/{id:[0-9]*}');
        $this->addResource('/rf/templates/field/{action:add|duplicate|delete}/{id:[0-9]*}');
        $this->addResource('/rf/templates/field/{action:rename|update|sort}/{id:[0-9]*}');
        
        // Basic Permission for all users (also not logged in)

        $this->allow(
          'guest', 
          '/rf',
          'GET'
        );
        $this->allow(
          'guest',
          '/rf/',
          'GET'
        );
        $this->allow(
          'guest',
          '/rf/login',
          ['GET', 'POST']
        );

        // Regular Users
        
        $this->allow(
          'user',
          '/rf/logout',
          'GET'
        );
        $this->allow(
          'user',
          '/rf/dashboard',
          'GET'
        );
        $this->allow(
          'user',
          '/rf/menu',
          'GET'
        );
        $this->allow(
          'user',
          '/rf/contributions/search',
          'POST'
        );
        $this->allow(
          'user',
          '/rf/contributions/{book:[0-9]*}/{issue:[0-9]*}/{chapter:[0-9]*}', 
          ['GET','POST']
        );
        $this->allow(
          'user',
          '/rf/contribution/{id:[0-9]*}',
          'GET'
        );
        $this->allow(
          'user',
          '/rf/contribution/{action}/{id:[0-9]*}',
          'POST'
        );
        $this->allow(
          'user',
          '/rf/field/{id:[0-9]*}',
          'POST'
        );
        $this->allow(
          'user',
          '/rf/profile',
          ['GET','POST']
        );
        
        // Administrators
        $this->allow(
          'admin', 
          '/rf/structure',
          ['GET','POST']
        );
        $this->allow(
          'admin', 
          '/rf/structure/{action:rename|rights}/{type}/{id:[0-9]*}',
          'POST'
        );
        $this->allow(
          'admin', 
          '/rf/structure/{action:add|sort}/{type}[/{id:[0-9]*}]',
          'POST'
        );
        $this->allow(
          'admin', 
          '/rf/structure/{action:duplicate|delete|open|close}/{type}/{id:[0-9]*}',
          'GET'
        );
        $this->allow(
          'admin', 
          '/rf/templates',
          ['GET','POST']
        );
        $this->allow(
          'admin', 
          '/rf/templates/{action:add|duplicate|delete}[/{id:[0-9]*}]',
          ['GET','POST']
        );
        $this->allow(
          'admin', 
          '/rf/templates/{action:rename|update}/{id:[0-9]*}',
          'POST'
        );
        $this->allow(
          'admin', 
          '/rf/templates/field/{action:add|duplicate|delete}/{id:[0-9]*}',
          ['GET','POST']
        );
        $this->allow(
          'admin', 
          '/rf/templates/field/{action:rename|update|sort}/{id:[0-9]*}',
          'POST'
        );

        // Roots can do everything!
        $this->allow(
          'root',
          '/rf/users',
          'GET'
        );
        $this->allow(
          'root',
          '/rf/user[/{id:new|[0-9]*}]',
          ['GET','POST']
        );        
        $this->allow(
          'root',
          '/rf/user/delete/{id:[0-9]*}',
          'GET'
        );   
        $this->allow(
          'root',
          '/rf/group[/{id:new|[0-9]*}]',
          ['GET','POST']
        );        
        $this->allow(
          'root',
          '/rf/group/delete/{id:[0-9]*}',
          'GET'
        );              

    }
}