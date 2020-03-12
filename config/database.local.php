<?php

// Database settings

return [
  'host'      => 'localhost',                     // Server Address
  'user'      => '',                              // User Name
  'pass'      => '',                              // Password
  'dbname'    => '',                              // Database Name
  'log'       => __DIR__ . '/../logs/propel.log', // Log File for Propel
  'level'     => \Monolog\Logger::ERROR,          // Error Level
  'versioning'=> false,                           // Experimental: Store Versions of Contributions and Data
  'pdo_emulate_prepare' => false                  // For some mysql servers, prepared statements tend to be buggy
                                                  // https://stackoverflow.com/questions/4380813/how-to-get-rid-of-mysql-error-prepared-statement-needs-to-be-re-prepared
  //'socket'  => '/tmp/mysql.sock',               // Unix Socket, normally not needed
  //'port'    => 3306,                            // Port, if default not needed
];
