<?php

// Redis Cache settings

return [
  'redis'     => false,                            // Enable Redis Cache
  'redis_ip'  => '127.0.0.1',                     // Ip of Redis Cache Server
  'redis_port'=> 6379,                            // Ip of Redis Cache Server
];


// Clustered Redis Setting

/*
return [
  'redis'     => false,                            // Enable Redis Cache
  'redis_ip'  => ['127.0.0.1', '127.0.0.2'],      // Ip of Redis Cache Server
  'redis_port'=> [6379, 6379],                    // Ip of Redis Cache Server
];
*/
