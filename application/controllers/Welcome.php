<?php
namespace controllers;
use base\Application;
use controllers\AdminController;

use helpers\Email;
use helpers\ErrorCode;
use helpers\Msg;
use helpers\Session;
use helpers\Tools;
use helpers\Validate;
use helpers\Arr;
use helpers\Timer;
use helpers\Queue;
use models\Logic\Oauth;
use helpers\Http;
use helpers\Cookie;


class Welcome extends AdminController{
	public $render_engine = 'php';

    public function index(){
         $sdk_ad = D('sdk_ad')->where("1")->limit(1)->fetch();
         print_r($sdk_ad);
         $sdk_ad = D('sdk_user','sdk')->where("1")->limit(1)->fetch();
         print_r($sdk_ad);
        echo "hello";
    }

    public function db_switch(){

    }

    public function test_s(){
      Session::set("a.b",[1,2,3]);

    }

    public function test_s2(){
        var_dump(Session::get("a.b"));
    }

    public function cookie(){
        Cookie::set("login_user",['name'=>'zhangsan','uid'=>'10000','expire'=>86400]);
    }

    public function get_cookie(){
       var_dump(Cookie::get("login_user"));
    }




}