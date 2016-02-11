rokfor-slim
===========

Complete Rokfor rebuild based on the (Slim Framework)[http://slimframework.com/]
for PHP.

Other components used:

-   Installable via composer

-   AdminLTE as Templates

-   Propel ORM

 

Please note: This repository is still under development. There's no need to
check it out so far.

 

Prerequisites:

-   MySQL Database with username and password

-   PHP \>= 5.4

-   (Composer)[<https://getcomposer.org>]

 

Installation process:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
$ composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

Configure Rokfor:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ cd src
$ pico settings.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You need to change the database settings.

 

Popuplate Database:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd vendor/rokfor/db/config
$ pico propel.yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Edit the connection settings in the *propel.yaml* file.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ ../../../propel/propel/bin/propel sql:insert
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now, the database should be populated with the correct strucuture

 

Run php as a local server:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ php -S 0.0.0.0:8080 -t public public/index.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

Now you should be able to browse to http://localhost:8080/rf and log in with the
default user root and password 1234.
