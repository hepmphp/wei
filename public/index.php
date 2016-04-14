<?php

define('BASE_PATH',__DIR__);
define('APP_PATH',BASE_PATH.'/../application');
include APP_PATH.'/base/Loader.php';
spl_autoload_register('\\base\Loader::autoload');//自有类库自动载入
include BASE_PATH.'/../vendor/autoload.php';//第三方类库自动载入
helpers\Timer::go('test');
$config = array();
base\Application::getInstance(APP_PATH)->run();

echo "<pre>";
print_r(base\Application::get_db()->log());