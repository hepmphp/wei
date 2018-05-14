<?php
define('DEBUG',true);
define('BASE_PATH',__DIR__);
define('APP_PATH',BASE_PATH.'/../application');
include APP_PATH.'/base/Loader.php';
spl_autoload_register('\\base\Loader::autoload');//��������Զ�����
include BASE_PATH.'/../vendor/autoload.php';//����������Զ�����
if(DEBUG){
    helpers\Timer::go('test');
}
if(!is_array($argv)){
    throw new Exception('error params');
}
$_SERVER['PATH_INFO'] = $argv[1];
$_SERVER['REQUEST_URI'] = $argv[1];
$config = array();
base\Application::getInstance(APP_PATH)->run();
if(DEBUG){
    echo "<pre>";
    print_r(base\Application::get_db()->log());
    print_r(base\Application::get_db('slave')->log());
    print_r(\helpers\Debug::last_log());
}

/*
     �÷�
 *   php -f cli.php  welcome/id
 *   php -f cli.php  test/admin/test
 */