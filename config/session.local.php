<?php

// Session Handler

// If handler is not equal to 'redis', the default session handler
// will be used.
// If you are running rokfor in a distributed environment, i.E on Amazon
// Cloud Services, it is important that sessions are distributed among the
// various instances.

return [
  'handler'     => 'redis',                            // Enable Redis Cache
  'redis_ip'    => '127.0.0.1',                     // Ip of Redis Cache Server
  'redis_port'  => 6379,                            // Ip of Redis Cache Server
];
