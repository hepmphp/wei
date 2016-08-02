<?php
namespace controllers;
use base\BaseController;

class Welcome extends BaseController{
    public function index(){
        echo __FILE__;
    }
    public function trigger_error(){
       // trigger_error('hello');
        $a['a'] = 0;
        var_dump($a['b']);
    }
}