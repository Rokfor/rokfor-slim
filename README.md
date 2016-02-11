rokfor-slim
===========

Complete Rokfor rebuild based on the [Slim Framework](http://slimframework.com/)
for PHP.

![Dashboard](https://github.com/Rokfor/rokfor-slim/blob/gh-pages/rokfor-screenshots/rf-dashboard.png)

Other components used:

-   Installable via composer
-   AdminLTE as Templates
-   Propel ORM

Please note: This repository is still under development. There's no need to
check it out so far.



Prerequisites
-------------

-   MySQL Database: Server, username, password and database name
-   PHP \>= 5.4
-   [Composer](https://getcomposer.org)



Installation process
--------------------

Open a terminal, clone the repository and install the dependencies with composer:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
$ composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Configure Rokfor
----------------

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ cd src
$ pico settings.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You need to change the database settings in _settings.php_. It's pretty straight
forward. Change the following lines:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Database settings
'db' => [
  'host'          => 'server',
  'user'          => 'user',
  'pass'          => 'password',
  'dbname'        => 'tablename',
  ...
]
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~


Popuplate Database
------------------

Rokfor uses Propel as database object mapper. Propel is loaded via composer and
installed in the vendor directory. First, edit the configuration file in order
to make the Propel command line untility running.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd vendor/rokfor/db/config (relative from the repository base directory)
$ pico propel.yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Edit the connection settings in the *propel.yaml* file. 
Run the propel cli utility to inject the structure:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ ../../../propel/propel/bin/propel sql:insert (from the directory above)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now, the database should be populated with the correct strucuture and a default
user is automatically added.


Run php as a local server
-------------------------

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ php -S 0.0.0.0:8080 -t public public/index.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now you should be able to browse to http://localhost:8080/rf and log in with the
default user root and password 1234. If you use Rokfor with Apache make sure, that
the server's document root points to _public_. _mod_rewrite_ is also necessary to
redirect all traffic over _index.html_.
