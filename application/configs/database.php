<?php

$config['master'] = [
    'database_type' => 'mysql',
    'database_name' => 'cgfx',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'gbk'
];
$config['slave'] = [
    'database_type' => 'mysql',
    'database_name' => 'hotel',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'gbk'
];

return $config;