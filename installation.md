---
layout: backend
title: Installation
permalink: /installation
---

<h2>
<a id="setup-and-installation" class="anchor" href="#setup-and-installation" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Setup and Installation</h2>

<h3>
<a id="1-prerequisites" class="anchor" href="#1-prerequisites" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>1. Prerequisites</h3>

<ul>
<li>  MySQL Database: Server, username, password and database name</li>
<li>  PHP &gt;= 5.5</li>
<li>  <a href="https://getcomposer.org">Composer</a>
</li>
</ul>

<h3>
<a id="2-install-dependencies" class="anchor" href="#2-install-dependencies" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>2. Install Dependencies</h3>

<p>Clone the repository and install the dependencies with composer:</p>

<pre><code>$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
</code></pre>

<h3>
<a id="3-configuration" class="anchor" href="#3-configuration" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>3. Configuration</h3>

<p>First, create copies of the database and settings configuration file. Rename or
copy the *.local.php to *.php files:</p>

<pre><code>$ cd config
$ cp database.local.php database.php
$ cp settings.local.php settings.php
</code></pre>

<p>The options in the <strong>settings.php</strong> file don't need to be changed as long as you keep
the directory structure. Talking about <strong>directories</strong>: Make sure, that the webserver 
has access to the <em>udb</em> and <em>cache</em> folder:</p>

<pre><code>public         _Webserver Document Root_
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
</code></pre>

<p>Second, you need to change the database settings in <strong>database.php</strong>. To achieve that,
you need to know the User, Password, Database and Server for your MySQL Account.
If you enable <strong>versioning</strong> in the configuration file, all changes of contributions
are tracked. This is useful in cases you want to keep the editing history. As a downside,
it will create a lot of data.
If you change the log <strong>level</strong> to \Monolog\Logger::DEBUG, all sql queries are
logged. The path to the log file can be adjusted in the <strong>log</strong> setting.</p>

<pre><code>// Database settings

return [
  'host'      =&gt; 'localhost',                     // Server Address
  'user'      =&gt; '',                              // User Name
  'pass'      =&gt; '',                              // Password
  'dbname'    =&gt; '',                              // Database Name
  'log'       =&gt; __DIR__ . '/../logs/propel.log', // Log File for Propel
  'level'     =&gt; \Monolog\Logger::ERROR,          // Error Level
  'versioning'=&gt; false,                           // Store Versions of  
                                                  // Contributions and Data
  //'socket'  =&gt; '/tmp/mysql.sock',               // Unix Socket, normally
                                                  // not needed
  //'port'    =&gt; 3306,                            // Port, if default not needed
];
</code></pre>

<h3>
<a id="4-populate-database" class="anchor" href="#4-populate-database" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>4. Populate Database</h3>

<p><strong>Normally, the database is initialized when you log in for the first time. If no
error occured, you can skip this chapter.</strong></p>

<p>Rokfor relies on <a href="http://propelorg.org">Propel</a> as database object mapper.
Propel is loaded via composer and installed like all other dependencies in the
vendor subdirectory. The connection between rokfor and Propel is established with
<a href="https://github.com/rokfor/rokfor-php-db">rokfor-php-db</a>.</p>

<p>You need to run the <strong>Propel CLI</strong> tool to populate the database. Propel needs to
know how to access your database. This is done in the configuration file.
Edit the connection settings in the <strong>propel.yaml</strong> file similar to the
configuration file above. Change server, database, user and password and save
the file:</p>

<pre><code>$ pico vendor/rokfor/db/config/propel.yaml

dsn: mysql:host=SERVER;dbname=DBNAME;unix_socket=/tmp/mysql.sock;
user: USERNAME
password: PASSWORD
</code></pre>

<p>Now you are ready to run the <strong>Propel CLI</strong> utility with the <strong>insert</strong> parameter. 
The command below assumes that you are still in the directory where you checked out
rokfor-slim:</p>

<pre><code>$ ./vendor/bin/propel sql:insert \
--config-dir ./vendor/rokfor/db/config \
--sql-dir ./vendor/rokfor/db/config/generated-sql/
</code></pre>

<p>Now, the database should be populated with the correct strucuture and a default
user is automatically added (Username: root, Password: 123).</p>

<h2>
<a id="running-rokfor" class="anchor" href="#running-rokfor" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Running Rokfor</h2>

<h3>
<a id="php-server-mode-debug" class="anchor" href="#php-server-mode-debug" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>PHP Server Mode (Debug)</h3>

<pre><code>$ cd rokfor-slim (base directory of the repository)
$ php -S 0.0.0.0:8080 -t public public/index.php
</code></pre>

<p>Now you should be able to browse to <strong>http://localhost:8080/rf</strong> and log in with
the default user <strong>root</strong> and password <strong>123</strong>.</p>

<h3>
<a id="behind-apache" class="anchor" href="#behind-apache" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Behind Apache</h3>

<p>There are 3 important things to keep in mind when running Rokfor with Apache:
1. Make sure that the webserver has read/write access to both <strong>cache</strong> und <strong>udb</strong> directory
2. The server's document_root needs to point to the <strong>public</strong> directory. If you can not change this,
rename the directory according to your server configuration and reconfigure the settings.php file.
3. <strong>mod_rewrite</strong> is also necessary to redirect all traffic over <strong>index.html</strong>.</p>

<h2>
<a id="building-rokfor" class="anchor" href="#building-rokfor" aria-hidden="true"><span aria-hidden="true" class="octicon octicon-link"></span></a>Building Rokfor</h2>

<p>Rokfor uses grunt to build and bower to install dependencies. Assuming you have
installed node and npm:</p>

<pre><code>$ npm install
$ bower install
$ grunt
</code></pre>

<p>The grunt task minifies the css files and creates the javascript bundles and copies
all files into the public directory. Building is only needed if you want to develop
and contribute something to Rokfor.</p>
