<?php

define('BASE_PATH',__DIR__);
define('APP_PATH',BASE_PATH.'/../application');
include APP_PATH.'/core/Loader.php';
spl_autoload_register('\\core\Loader::autoload');//自有类库自动载入
include BASE_PATH.'/../vendor/autoload.php';//第三方类库自动载入
helpers\Timer::go('test');
$config = array();
core\Application::getInstance()->run($config);

echo "<pre>";
//print_r(core\Application::getInstance());