<?php
namespace base;

use helpers\Cache\CacheFactory;
use helpers\Input;
use helpers\Session;
use base\db\QueryBuilder;


class Application {
    protected static $instance;
    protected static $db;
    public $config;
    public $app_path;
    public $path;
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
            self::$db[$instance] =   QueryBuilder::getInstance($master);
        }
        return self::$db[$instance];
    }

    protected function __construct($app_path)
    {
        $this->app_path = $app_path;
        $this->config = new Config($app_path.'/configs');
    }


    public function run(){
        $this->handle_error_and_exception();
        $this->init_dependences();
        $this->dispatch();


//        echo "<pre>";
//        print_r($_SERVER);
    }
    public function init_dependences(){
		//载入系统常量
		include_once $this->app_path.'/configs/const.php';
        //db

        //sessoin sessoin初始化
        Session::init();

        //缓存
    }

    public function handle_error_and_exception(){
        set_error_handler(array('helpers\Handler','error_handler'));
        //set_exception_handler('_exception_handler');
        register_shutdown_function(array('helpers\Handler','shutdown_handler'));
    }

    public function dispatch(){
        $this->_parse_routes();
        $path_info = $this->_parse_path_info();
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
        $this->path = $path;
        $class = ucwords($class);
        $this->controller = $class;
        $class = empty($path)?'\\controllers\\'.$class:"\\controllers\\{$path}\\".$class;
        $controller = new $class;

        if(method_exists($controller,$method)){
            $this->action = $method;
            $controller->$method();
        }else{
            throw new \Exception("{$class} has not method {$method}");
        }
    }
    
      public function _parse_routes(){

        $routes = Application::getInstance()->config['routes'];
        if(empty($routes))return array();
        $parse_route = '';
        foreach($routes as $rule=>$route){
            // Convert wild-cards to RegEx
            $rule = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $rule));
            // Does the RegEx match?
            if (isset($_SERVER['PATH_INFO']) && preg_match('#'.$rule.'$#', $_SERVER['PATH_INFO'],$matchRule))
            {
                if (strpos($route, '$') !== FALSE AND strpos($rule, '(') !== FALSE)
                {
                    foreach($matchRule as $key=>$m_rule){
                        if($key==0)continue;
                        $route =  str_replace('$'.$key,$m_rule,$route);
                    }

                }

                $parse_route = parse_url($route);
                $_SERVER['PATH_INFO'] = $parse_route['path'];
                if(isset($parse_route['query'])){
                    $_SERVER['QUERY_STRING'] = $parse_route['query'];
                    parse_str($parse_route['query'],$_GET);//解析路由配置参数填充到$_GET参数
                    parse_str($parse_route['query'],$_REQUEST);//解析路由配置参数填充到$_REQUEST
                }
            }
        }
    }

    public function _parse_path_info(){
        $path_info = isset($_SERVER['PATH_INFO'])&&!empty($_SERVER['PATH_INFO'])?explode('/',$_SERVER['PATH_INFO']):array(DEFAULT_CONTROLLER);
        /**g分组 m控制器 a方法*/
        $g = Input::get('g');
        $m = Input::get('m');
        $a = Input::get('a');
        if($m&&$a){
            $path_info = array();
            $path_info[] = $g;
            $path_info[] = $m;
            $path_info[] = $a;
        }
        return $path_info;
    }

 
}



