rokfor-slim
===========

Rokfor rebuild based on the [Slim Framework](<http://slimframework.com/>) for
PHP. Rokfor is a api first data centristic content management. It currently
features:

 

-   Flexible structures called "Books", divided into parts, called "Chapters".

-   Every book can have multiple instances called "Issues".

-   Every Chapter contains data, called "Contributions".

-   "Contributions" are collections of fields, gathered in templates.

-   Various data types supported: Text, Text Arrays, RTF Text, Tables, Numbers,
    Dates, Locations, Image and File uploads, Tags, Selectors, Sliders, Two Way
    Sliders.

-   Various data relations: field to fields, field to structures, fixed values
    and many more.

-   Read only api with a simple bearer-key authentification based on user
    rights.

-   Fine grained roles and rights system.

-   Installable via composer, using grunt and bower as build system.

 

![Dashboard](<https://github.com/Rokfor/rokfor-slim/blob/gh-pages/rokfor-screenshots/rf-dashboard.png>)

 

Rokfor is a project with a longer history. The [first
build](<https://github.com/Rokfor/rokfor-cms>) is mainly used to create printed
matter. In order to make it more useful for the public, we decided to rewrite it
completely applying a modern way of writing php applications:

 

-   Composer install system

-   AdminLTE backend theme

-   Propel ORM

 

Setup and Installation
----------------------

 

### 1. Prerequisites

-   MySQL Database: Server, username, password and database name

-   PHP \>= 5.4

-   [Composer](<https://getcomposer.org>)

 

### 2. Install Dependencies

Open a terminal, clone the repository and install the dependencies with
composer:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
$ composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

### 3. Copy and Edit Configuration Files

First, you need a copy of the database and settings configuration file. Move or
copy the .local.php files to .php files:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd config
$ cp database.local.php database.php
$ cp settings.local.php settings.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Then, you need to change the database settings in *database.php*. You need to
know the User, Password, Database and Server for your MySQL Account.

If you enable **versioning**, all changes within contributions are stored as
versions. This can be useful if you need to track the editing history, but it
will create a lot of data.

If you change the log **level** to \\Monolog\\Logger::DEBUG, all sql queries are
logged. The path to the log file can be adjusted in the **log** setting.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Database settings

return [
  'host'      => 'localhost',                     // Server Address
  'user'      => '',                              // User Name
  'pass'      => '',                              // Password
  'dbname'    => '',                              // Database Name
  'log'       => __DIR__ . '/../logs/propel.log', // Log File for Propel
  'level'     => \Monolog\Logger::ERROR,          // Error Level
  'versioning'=> false,                           // Store Versions of  
                                                  // Contributions and Data
  //'socket'  => '/tmp/mysql.sock',               // Unix Socket, normally 
                                                  // not needed
  //'port'    => 3306,                            // Port, if default not needed
];
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

### 4. Populate Database

Rokfor relies on [Propel](<http://propelorg.org>) and as database object mapper.
Propel is loaded via composer and installed like all other dependencies in the
vendor subdirectory. The connection between rokfor and Propel is delivered with
rokfor-php-db, a standalone adapter package.

You need a running Propel CLI tool to populate the database. The first step is a
correct configuration file:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ pico vendor/rokfor/db/config/propel.yaml
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
$ ./vendor/bin/propel sql:insert \
--config-dir ./vendor/rokfor/db/config \
--sql-dir ./vendor/rokfor/db/config/generated-sql/
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now, the database should be populated with the correct strucuture and a default
user is automatically added.

 

Running Rokfor
--------------

 

### PHP Server Mode (Debug)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ php -S 0.0.0.0:8080 -t public public/index.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now you should be able to browse to **http://localhost:8080/rf** and log in with
the default user **root** and password **1234**.

 

### Behind Apache

If you run Rokfor with Apache make sure, that the server's document root points
to *public*. *mod\_rewrite* is also necessary to redirect all traffic over
*index.html*.

 

Building Rokfor
---------------

 

Rokfor uses grunt to build and bower to install dependencies. Assuming you have
installed node and npm:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ npm install
$ bower install 
$ grunt
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

Read Only API
-------------

 

### Access Key

In order to access data, you need to set a user and define a read only api key
in the user profile. Adding a user is only possible if you are signed in as
root. There are two reasons why we use api keys for read only access. First, you
can define which data is published, second, a key is not a password. Even by
publishing a key, there's no way to log into the system and edit content.

Sending the key is done via a bearer authentification header or a access\_token
query string. Sending a header is probably a better solution since the query
string won't be too cluttered and the api key probably does not show up in the
server log. The GET-call is probably a little bit more difficult to generate
though.

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
GET /api/contributions/1/1?access_token=[key]

$ curl -H "Authorization: Bearer [key]" http://localhost:8080/api/contributions/1/1
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

### Current API Routes

**Loading a collection of contributions with options:**

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
GET /api/contributions/[:issueid]/[:chapterid]?[options]

Options:

- query=string
- sort=[id|date|name:]asc|desc
- limit=int
- offset=int
- populate=[Fieldname|Fieldname|XX]
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

-   Query: search for a string within the contribution name or the text fields

-   Sort: Sort the results by id, date or name either ascending or descending

-   Limit and Offset: Create pages with a length of [limit] elements starting at
    [offset].

-   Populate: Add additional field infos to the result set of a contributions.
    For example, you need the title field of a contribution already in the
    result set to create a multilingual menu. Or you need all images for a
    slideshow over multiple contributions.

 

**Loading a single contribution:**

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
GET /api/contribution/[:id]
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Loads all available data from a single contribution.

 

Roadmap
-------

 

In the current state, Rokfor is able to store and organize data. On the roadmap
there are additional functions which will be re-implemented:

 

>   \- Read / write api (jwt authentification).  
>   - Batch functions: Run an action over all contributions of a certain
>   chapter.  
>   - Field processors: Run an action when storing data.  
>   - Exporters: Convert data into other formats (i.e. PDF)
