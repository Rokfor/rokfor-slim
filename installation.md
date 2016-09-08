---
layout: backend
title: Installation
permalink: /installation
---

## Setup and Installation

### Prerequisites

*   MySQL Database: Server, username, password and database name
*   PHP >= 5.5
*   [Composer](https://getcomposer.org)

### Install Dependencies

Clone the repository and install the dependencies with composer:

    $ git clone https://github.com/Rokfor/rokfor-slim.git
    $ cd rokfor-slim
    $ composer install

### Configuration

First, create copies of the database and settings configuration file. Rename or copy the *.local.php to *.php files:

    $ cd config
    $ cp database.local.php database.php
    $ cp settings.local.php settings.php
    $ cp redis.local.php redis.php    

The options in the **settings.php** file don't need to be changed as long as you keep the directory structure. Talking about **directories**: Make sure, that the webserver has access to the _udb_ and _cache_ folder:

    public         _Webserver Document Root_
    | index.php    
    | udb          _Default Storage directory, chmod r/w for the webserver_
    | assets
    config         _Configuration Files_
    locale         _Localization Files, currently only german_
    cache          _Template Cache_
    src            _Rokfor PHP Runtime Sources_
    vendor         _Composer Dependencies_
    templates      _Jade Templates_
    build          _Css and Javascript Sources_

Second, you need to change the database settings in **database.php**. To achieve that, you need to know the User, Password, Database and Server for your MySQL Account. If you enable **versioning** in the configuration file, all changes of contributions are tracked. This is useful in cases you want to keep the editing history. As a downside, it will create a lot of data. If you change the log **level** to \Monolog\Logger::DEBUG, all sql queries are logged. The path to the log file can be adjusted in the **log** setting.

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

> Populate Database
> 
> **Normally, the database is initialized when you log in for the first time. If no error occured, you can skip this chapter.**
> 
> Rokfor relies on [Propel](http://propelorg.org) as database object mapper. Propel is loaded via composer and installed like all other dependencies in the vendor subdirectory. The connection between rokfor and Propel is established with [rokfor-php-db](https://github.com/rokfor/rokfor-php-db).
> 
> You need to run the **Propel CLI** tool to populate the database. Propel needs to know how to access your database. This is done in the configuration file. Edit the connection settings in the **propel.yaml** file similar to the configuration file above. Change server, database, user and password and save the file:
> 
>     $ pico vendor/rokfor/db/config/propel.yaml
> 
>     dsn: mysql:host=SERVER;dbname=DBNAME;unix_socket=/tmp/mysql.sock;
>     user: USERNAME
>     password: PASSWORD
> 
> Now you are ready to run the **Propel CLI** utility with the **insert** parameter. The command below assumes that you are still in the directory where you checked out rokfor-slim:
> 
>     $ ./vendor/bin/propel sql:insert \
>     --config-dir ./vendor/rokfor/db/config \
>     --sql-dir ./vendor/rokfor/db/config/generated-sql/
> 
> Now, the database should be populated with the correct strucuture and a default user is automatically added (Username: root, Password: 123).

## Running Rokfor

### PHP Server Mode

    $ cd rokfor-slim (base directory of the repository)
    $ php -S 0.0.0.0:8080 -t public public/index.php

Now you should be able to browse to **http://localhost:8080/rf** and log in with the default user **root** and password **123**.

### Apache

There are 3 important things to keep in mind when running Rokfor with Apache: 
- Make sure that the webserver has read/write access to both **cache** and **udb** and **_private** directory.
- The server's document_root needs to point to the **public** directory. If you can not change this, rename the directory according to your server configuration and reconfigure the settings.php file. 
- **mod_rewrite** is also necessary to redirect all traffic over **index.html**.

### Nginx

Rokfor runs also with Nginx:

    server {
        listen 80;
        server_name example.com;
        index index.php;
        error_log /path/to/example.error.log;
        access_log /path/to/example.access.log;
        root /path/to/public;
        
        location / {
            try_files $uri /index.php$is_args$args;
        }
    
        location ~ \.php {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param SCRIPT_NAME $fastcgi_script_name;
            fastcgi_index index.php;
            fastcgi_pass 127.0.0.1:9000;
        }
    }


There is a file called `nginx_app.conf` if you want do deploy Rokfor with dokku. (Still working on the documentation here!). 

## Building Rokfor

Rokfor uses grunt to build and bower to install dependencies. Assuming you have installed node and npm:

    $ npm install
    $ bower install
    $ grunt

The grunt task minifies the css files and creates the javascript bundles and copies all files into the public directory. Building is only needed if you want to develop and contribute something to Rokfor.