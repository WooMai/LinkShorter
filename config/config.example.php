<?php

$Config['app_name'] = 'LinkShorter';
$Config['debug'] = true;
$Config['default_timezone'] = 'Asia/Shanghai';

$Config['root_url'] = 'https://example.com';

$Config['mysql'] = array(
    'connect_type' => 'network',  // or socket

    'host' => '127.0.0.1',
    'port' => 3306,

    'socket' => '/tmp/mysql.sock',

    'name' => 'example_db',
    'user' => 'root',
    'pass' => '114514',
    'prefix' => ''
);

$Config['redis'] = array(
    'connect_type' => 'network',  // or socket

    'host' => '127.0.0.1',
    'port' => 6379,

    'socket' => '/tmp/redis.sock',

    'passwd' => null,
    'default_db' => 0
);

# DO NOT TOUCH
if (!defined('SYSTEM_CONFIG')) {
    define('SYSTEM_CONFIG', $Config);
}