<?php
namespace base;

class Application {
    protected static $instance;
    protected static $db;
    public $config;
    public $app_path;
    public $controller;
    public $action;

    static function getInstance($app_path = '')
    {
        if (empty(self::$instance))
        {
            self::$instance = new self($app_path);
        }
        return self::$instance;
    }
    static function get_db($instance='master'){
        $master = Application::getInstance()->config['database'][$instance];
        if(empty(self::$db[$instance])){
            self::$db[$instance] =   medoo::getInstance($master);
        }
        return self::$db[$instance];
    }

    protected function __construct($app_path)
    {
        $this->app_path = $app_path;
        $this->config = new Config($app_path.'/configs');
    }


    public function run(){

        $this->dispatch();
        $this->init_dependences();
//        echo "<pre>";
//        print_r($_SERVER);
    }
    public function init_dependences(){
        //db
        //缓存
    }

    public function handle_error_and_exception(){
        set_error_handler('_error_handler');
        set_exception_handler('_exception_handler');
        register_shutdown_function('_shutdown_handler');
    }

    public function dispatch(){
        $path_info = explode('/',$_SERVER['PATH_INFO']);
        $path_info = array_values(array_filter($path_info));
        $path = '';
        $class = '';
        $method = '';
        if(count($path_info)==3){
            list($path,$class,$method) = $path_info;
        }else if(count($path_info)==2){
            list($class,$method) = $path_info;
        }else{
            $class = $path_info[0];
            $method = 'index';
        }
        $class = ucwords($class);
        $class = empty($path)?'\\controllers\\'.$class:"\\controllers\\{$path}\\".$class;
        $this->controller = new $class;

        if(method_exists($this->controller,$method)){
            $this->action = $method;
            $this->controller->$method();
        }else{
            throw new \Exception("{$class} has not method {$method}");
        }
    }
}