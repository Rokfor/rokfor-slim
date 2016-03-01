rokfor-slim
===========

Complete Rokfor rebuild based on the [Slim
Framework](<http://slimframework.com/>) for PHP. Rokfor is a api first data
centristic content management. It currently features:

 

-   Flexible structures called "Books", divided into parts, called "Chapters".

-   Every book can have multiple instances called "Issues".

-   Every Chapter contains data, called "Contributions".

-   Flexible data templates supporting various data types: Text, Text Arrays,
    RTF Text, Tables, Numbers, Dates, Locations, Image and File uploads, Tags,
    Selectors, Sliders, Two Way Sliders.

-   Selectors with various relations: to other fields, to structures, fixed
    values and many more.

-   Read only api (simple bearer authentification).

 

Todos:

 

In the current state, Rokfor is useful to store data. On the roadmap there are
some additional functions which will be implemented soon:

 

-   Read / write api (jwt authentification).

-   Batch functions: Run an action over all contributions of a certain chapter.

-   Field processors: Run an action when storing data.

-   Exporters: Convert data into other formats (i.e. PDF)

 

![Dashboard](<https://github.com/Rokfor/rokfor-slim/blob/gh-pages/rokfor-screenshots/rf-dashboard.png>)

 

Rokfor is a project with a longer history. The [first
build](<https://github.com/Rokfor/rokfor-cms>) is mainly used to create printed
matter. In order to make it more useful for the public, we decided to rewrite it
completely using standard tools and a modern way of writing php applications.

 

-   Installable via composer

-   AdminLTE as Templates

-   Propel ORM

Prerequisites
-------------

-   MySQL Database: Server, username, password and database name

-   PHP \>= 5.4

-   [Composer](<https://getcomposer.org>)

Installation process
--------------------

Open a terminal, clone the repository and install the dependencies with
composer:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
$ composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Copy Configuration Files
------------------------

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd config
$ cp database.local.php database.php
$ cp settings.local.php settings.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Configure MySQL Database
------------------------

You need to change the database settings in *database.php*. It's pretty straight
forward. Change the following lines:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
'user'               => '',
'pass'               => '',
'dbname'             => '',
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Popuplate Database
------------------

Rokfor relies on [Propel](<http://propelorg.org>) and as database object mapper.
Propel is loaded via composer and installed like all other dependencies in the
vendor subdirectory. The connection between rokfor and Propel is delivered with
rokfor-php-db, a standalone adapter package.

You need a running Propel CLI tool to populate the database. The first step is a
correct configuration file:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd vendor/rokfor/db/config
$ pico propel.yaml
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Edit the connection settings in the *propel.yaml* file similar to the
configuration file above. Change server, database, user and password and save
the file:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
dsn: mysql:host=SERVER;dbname=DBNAME;unix_socket=/tmp/mysql.sock;
user: USERNAME
password: PASSWORD
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Run the Propel CLI utility with the insert parameter. The command below assumes
that you are still in the directory where the propel.yaml file resides:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ ../../../propel/propel/bin/propel sql:insert
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
default user root and password 1234.

Using Rokfor with Apache
------------------------

If you run Rokfor with Apache make sure, that the server's document root points
to *public*. *mod\_rewrite* is also necessary to redirect all traffic over
*index.html*.

 

more to come - this is still an alpha release.
