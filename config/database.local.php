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
  'redis'     => true,                            // Enable Redis Cache
  'redis_ip'  => '127.0.0.1',                     // Ip of Redis Cache Server
  'redis_port'=> 6379,                            // Ip of Redis Cache Server
];
