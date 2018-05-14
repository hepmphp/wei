<?php
namespace base;
class Loader {
    static function autoload($class){
        $class_path = APP_PATH.'/'.str_replace('\\', '/', $class).'.php';
       // echo $class_path.PHP_EOL."<br/>";
        /*
        if(strpos($class, 'models') !== false) {
            $class_path = APP_PATH.str_replace('\\', '/', $class).'.php';
        }*/
        include $class_path;
    }
}