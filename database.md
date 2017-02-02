### Populate Database

**Normally, the database is initialized when you log in for the first time. If no
error occured, you can skip this chapter.**

Rokfor relies on [Propel](<http://propelorg.org>) as database object mapper.
Propel is loaded via composer and installed like all other dependencies in the
vendor subdirectory. The connection between rokfor and Propel is established with
[rokfor-php-db](<https://github.com/rokfor/rokfor-php-db>).

You need to run the **Propel CLI** tool to populate the database. Propel needs to
know how to access your database. This is done in the configuration file.
Edit the connection settings in the **propel.yaml** file similar to the
configuration file above. Change server, database, user and password and save
the file:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ pico vendor/rokfor/db/config/propel.yaml

dsn: mysql:host=SERVER;dbname=DBNAME;unix_socket=/tmp/mysql.sock;
user: USERNAME
password: PASSWORD
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now you are ready to run the **Propel CLI** utility with the **insert** parameter.
The command below assumes that you are still in the directory where you checked out
rokfor-slim:

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$ ./vendor/bin/propel sql:insert \
--config-dir ./vendor/rokfor/db/config \
--sql-dir ./vendor/rokfor/db/config/generated-sql/
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Now, the database should be populated with the correct strucuture and a default
user is automatically added (Username: root, Password: 123).
