[![Build Status](https://travis-ci.org/Rokfor/rokfor-slim.svg?branch=master)](https://travis-ci.org/Rokfor/rokfor-slim)

rokfor-slim
===========

Rokfor build based on [Slim Framework](<http://slimframework.com/>) for PHP.
Rokfor is a api-first, data centristic content management. It currently
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
-   Read/Write Api based on JWT Tokens
-   Fine grained roles and rights system.
-   Installable via composer, using grunt and bower as build system.

Rokfor is optimized for speed, although complex search queries over a large database
can take quite a while. The problem lays in the nature of relational databases an the
complexity of creating many-to-many relations between fields.
Simple API calls are fast, since Rokfor implements caching methods on multiple levels:

-   Optionally using Redis as key/value storage for repeating queries if no data changes
    happened.
-   Using MySQL Cache tables if to speed up relational queries.

Binary uploads can either be stored locally on the server or pushed on a S3 compatible
storage provider.

Rokfor works best with Nginx and supports proxy caching and X-Accel-Headers for fast file
downloads.

![Dashboard](<https://github.com/Rokfor/rokfor-slim/blob/gh-pages/rokfor-screenshots/rf-dashboard.png>)

Rokfor has already a longer history. The [old build](<https://github.com/Rokfor/rokfor-cms>)
was mainly used to create printed matter. In order to make it more useful for the public, we
decided to rewrite it completely applying a modern way of writing php applications:

-   Composer install system
-   AdminLTE backend theme
-   Propel ORM

Setup and Installation
----------------------

### 1. Prerequisites
-   MySQL Database: Server, username, password and database name
-   PHP \>= 5.5
-   [Composer](<https://getcomposer.org>)

### 2. Install Dependencies
Clone the repository and install the dependencies with composer:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ git clone https://github.com/Rokfor/rokfor-slim.git
$ cd rokfor-slim
$ composer install
$ composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

### 3. Configuration
First, create copies of the database and settings configuration file. Rename or
copy the *.local.php to *.php files:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd config
$ cp database.local.php database.php
$ cp settings.local.php settings.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The options in the **settings.php** file don't need to be changed as long as you keep
the directory structure. Talking about **directories**: Make sure, that the webserver
has access to the _udb_ and _cache_ folder:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
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
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Second, you need to change the database settings in **database.php**. To achieve that,
you need to know the User, Password, Database and Server for your MySQL Account.
If you enable **versioning** in the configuration file, all changes of contributions
are tracked. This is useful in cases you want to keep the editing history. As a downside,
it will create a lot of data.
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

Running Rokfor
--------------

### PHP Server Mode (Debug)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ cd rokfor-slim (base directory of the repository)
$ php -S 0.0.0.0:8080 -t public public/index.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now you should be able to browse to **http://localhost:8080/rf** and log in with
the default user **root** and password **123**.

### Apache
There are 3 important things to keep in mind when running Rokfor with Apache:
1. Make sure that the webserver has read/write access to both **cache** und **udb** directory
2. The server's document_root needs to point to the **public** directory. If you can not change this,
rename the directory according to your server configuration and reconfigure the settings.php file.
3. **mod\_rewrite** is also necessary to redirect all traffic over **index.html**.

Building Rokfor
---------------

Rokfor uses grunt to build and bower to install dependencies. Assuming you have
installed node and npm:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ npm install
$ bower install
$ grunt
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The grunt task minifies the css files and creates the javascript bundles and copies
all files into the public directory. Building is only needed if you want to develop
and contribute something to Rokfor.

Get some Data: Read Only API
----------------------------

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
GET /api/contributions/:issueid|:issueid-:issueid.../:chapterid|:chapterid-:chapterid...?[options]

Options:

- query=string                                                (default: empty)
- filter=[id|date|sort|templateid[s]]:[lt[e]|gt[e]|eq|like]   (default: [omitted]:like)
- sort=[[id|date|name|sort]|chapter|issue|templateid[s]]:[asc|desc]           (default: sort:asc)
- limit=int                                                   (default: empty)
- offset=int                                                  (default: empty)
- data=[Fieldname|Fieldname|XX]                               (default: empty)
- populate=true|false                                         (default: false)
- verbose=true|false                                          (default: false)
- template=id                                                 (default: empty)
- status=draft|published|both                                 (default: published)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

-   Query: search for a string within the contribution name or the text fields
    Special queries: date:now is transformed into the current time stamp
-   Filter: Applies the search string passed in query to certain fields, to the creation
    date, the contribution id or sort number.
    By default (if fields are omitted) the search query is applied to the name of the
    contribution and its content fields (full text search).
    Furthermore, the comparison can be defined with equal, less than, greater than
    or like (eq,lt,lte,gt,gte,like). Less and greater than does automatically cast
    a string to a number.
-   Sort: Sort the results by id, date, name or manual sort number (sort) either
    ascending or descending. It is also possible to sort by a custom id of a template field.
    Contributions can also be sorted by chapter or issue.
    Please note: You need to choose between id, date, name and sort. You can add one
    custom sort field and the chapter and issue flag. i.E:
    sort=date|chapter|issue|23 would sort by date, chapter, issue and the custom field 23.
-   Limit and Offset: Create pages with a length of [limit] elements starting at
    [offset].
-   Data: Add additional field infos to the result set of a contributions.
    For example, you need the title field of a contribution already in the
    result set to create a multilingual menu. Or you need all images for a
    slideshow over multiple contributions.
-   Populate: Sends all data (true). Equals data=All|Available|Fields
-   Verbose: Send complete Information about a dataset. In most cases, this
    is too much and just slowing down the connection.
-   Template: limit to a certain template id
-   Status: Including draft contributions, published contributions or both. Open
    Contributions are never shown.

Examples:

GET /api/contributions/1/14-5?query=New+York

    Searches for all contributions within issue 1 and chapters 14 and 5 for the String "New York".

GET /api/contributions/1/14-5?query=New+York&filter=1|6:eq

    Searches for all contributions within issue 1 and chapters 14 and 5 for the exact String "New York" within both fields with the template id 1 and 6.

GET /api/contributions/1/14-5?query=12&filter=sort:gtlimit=1

    Searches for all contributions within issue 1 and chapters 14 and 5 with a sort value > 12 and a limitation to 1 item. This represents the next contribution in a manually sorted list, since the list is has a default sort order by 'sort, asc'.

GET /api/contributions/1/14-5?query=12&filter=sort:lt&sort=sort:desc&limit=1

    Searches for all contributions within issue 1 and chapters 14 and 5 with a sort value < 12 and a limitation to 1 item, order descending. This represents the previous contribution in a manually sorted list.

GET /api/contributions/12/19?limit=10&offset=20

    Returns 10 contributions of issue 12 and chapter 19 starting after contribution 20.

GET /api/contributions/5-6-7/1-2-3?sort=date:desc&data=Title|Subtitle

    Returns all contributions of issue 5, 6 and 7 and chapter 1, 2 and 3 ordered by date, descending. Additionally, populates each contribution entry with the content of the fields Title and Subtitle.

GET /api/contributions/1/1?populate=true&verbose=true

    Returns all contributions of chapter 1 and issue 1. Adds all fields to each contribution and additionally prints a lot of information to each field and contribution.

GET /api/contributions/1/1?template=12

    Returns all contributions of chapter 1 and issue 1 based on the template 12

**Loading a single contribution:**

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
GET /api/contribution/:id?[options]

Options:

- verbose=true|false                   (default: false)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

-   Verbose: Send complete Information about a dataset. In most cases, this
    is too much and just slowing down the connection.

Examples:

GET /api/contributions/12?verbose=true

    Loads all available data from contribution with the id 12

**Structural Queries**

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
GET /api/books|issues|chapters/[:id]?[options]

Options:

- data=[Fieldname|Fieldname|XX]        (default: empty)
- populate=true|false                  (default: false)
- verbose=true|false                   (default: false)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

-   Data: Add additional field infos to the result set of a contributions.
    For example, you need the title field of a contribution already in the
    result set to create a multilingual menu. Or you need all images for a
    slideshow over multiple contributions.
-   Populate: Sends all data (true). Equals data=All|Available|Fields
-   Verbose: Send complete Information about a dataset. In most cases, this
    is too much and just slowing down the connection.

Examples:

GET /api/books

    Shows all books available for the current api key

GET /api/chapters/3

    Shows all information about chapter 3

GET /api/issue/2?verbose=true&populate=true

    Shows all information about issue 2. Additionally, raises the verbosity level and populates all data fields if a issue has backreferences to contributions.

Roadmap
-------

In the current state, Rokfor is able to store and organize data. On the roadmap
there are additional functions which will be implemented:

- Batch functions: Run custom actions over all contributions of a certain chapter.
- Field processors: Run an action when storing data.  
- Exporters: Convert data into other formats (i.e. PDF)
