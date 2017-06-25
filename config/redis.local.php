<?php

// Redis Cache settings

return [
  'redis'     => false,                            // Enable Redis Cache
  'redis_ip'  => '127.0.0.1',                     // Ip of Redis Cache Server
  'redis_port'=> 6379,                            // Ip of Redis Cache Server
];


// Clustered Redis Setting
// Currently, it seems that the clustered setup
// is far from fast. Try to avoid client side
// clustering and move to a seperate redis server
// if you run on distributed infrastructure

/*
return [
  'redis'     => false,                            // Enable Redis Cache
  'redis_ip'  => ['127.0.0.1', '127.0.0.2'],      // Ip of Redis Cache Server
  'redis_port'=> [6379, 6379],                    // Ip of Redis Cache Server
];
*/
