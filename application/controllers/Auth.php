<?php

namespace controllers;
use base\Application;
use base\BaseController;
use models\Logic\Oauth;
use helpers\Debug;

class Auth extends BaseController{

    public function get_access_token(){

        $user = 'test';
        $pass = '123456';
        $ip = $_SERVER['REMOTE_ADDR'];
        $m_oauth = new Oauth();
        $result = $m_oauth->get_token($ip,$user,$pass);
        echo json_encode($result);
    }

    public function debug(){
        echo "<pre>";
        echo json_encode($_SERVER);
    }
}