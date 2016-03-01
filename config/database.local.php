<?php

// Database settings

return [
  'host'      => 'localhost',                     // Server Address
  'user'      => '',                              // User Name
  'pass'      => '',                              // Password
  'dbname'    => '',                              // Database Name
  'log'       => __DIR__ . '/../logs/propel.log', // Log File for Propel
  'level'     => \Monolog\Logger::ERROR,          // Error Level
  'versioning'=> false,                           // Store Versions of Contributions and Data
  //'socket'  => '/tmp/mysql.sock',               // Unix Socket, normally not needed
  //'port'    => 3306,                            // Port, if default not needed
];
