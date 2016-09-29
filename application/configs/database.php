<?php

$config['master'] = [
    'database_type' => 'mysql',
    'database_name' => 'web',
    'server' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'charset' => 'gbk',
    'query_cached'=>false,
];
$config['slave'] = [
    'database_type' => 'mysql',
    'database_name' => 'jipiao',
    'server' => '192.168.40.125',
    'username' => 'cncn',
    'password' => 'cncn@123#456',
    'charset' => 'gbk',
    'query_cached'=>\helpers\Cache\CacheFactory::FILE,
];

return $config;