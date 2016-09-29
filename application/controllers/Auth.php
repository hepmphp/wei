<?php

namespace controllers;
use base\Application;
use base\BaseController;
use models\Logic\Oauth;
use helpers\Debug;
class Auth extends BaseController{
    protected $render_engine = 'php';
    public function get_access_token(){
        $user = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $m_oauth = new Oauth();
        $result = $m_oauth->get_token($ip,$user,$pass);
        echo json_encode($result);
    }

    public function init(){
        $m_oauth = new Oauth();
        $result = $m_oauth->init($this->app->controller,$this->app->action);
        echo json_encode($result);
    }

    public function debug(){
		echo "<pre>";
        print_r(apache_request_headers());
    }
}