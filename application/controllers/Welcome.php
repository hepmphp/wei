<?php
namespace controllers;
use base\Application;
use controllers\AdminController;

use helpers\Email;
use helpers\ErrorCode;
use helpers\Msg;
use helpers\Tools;
use helpers\Validate;
use helpers\Arr;
use helpers\Timer;
use helpers\Queue;
use models\Logic\Oauth;
use helpers\Http;



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




}