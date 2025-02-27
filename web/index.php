<?php
define('DEBUG',TRUE);
define('BASE_PATH',__DIR__);
define('APP_PATH',BASE_PATH.'/../application');
error_reporting(E_ALL);
include APP_PATH.'/base/Loader.php';
spl_autoload_register('\\base\Loader::autoload');//自有类库自动载入
//include BASE_PATH.'/../vendor/autoload.php';//第三方类库自动载入
if(DEBUG){
	helpers\Timer::go('test');
}

base\Application::getInstance(APP_PATH)->run();
if(DEBUG){
	echo "<pre>";
	print_r(base\Application::get_db()->getLastSql());
//    print_r(base\Application::get_db('slave')->log());
   // print_r(\helpers\Debug::last_log());
}

