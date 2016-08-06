<?php
namespace controllers;
use base\BaseController;
use helpers\Debug;
use helpers\Email;
use helpers\ErrorCode;
use helpers\Msg;
use helpers\Validate;
use helpers\Arr;

class Welcome extends BaseController{
    public function index(){
        echo "<pre>";
        Debug::print_stack_trace();
    }
    public function trigger_error(){
       // trigger_error('hello');
        $a['a'] = 0;
        var_dump($a['b']);
    }

    public function  send_mail(){
        $email_title = 'hello just a test';
        $email_content = 'hello just a test';
        $to_users = '306863208@qq.com';
        $res = Email::send_mail($to_users,$email_title,$email_content);
        var_dump($res);
   }

    public function test_validate(){
        $data = array(
            'id'=>1,
        );

       if(!Validate::date($data['id'])){
            print_r(Msg::status_msg(ErrorCode::DB,Validate::get_error(Validate::DATE)));
       }
       if(!Validate::email($data['id'])){
           print_r(Msg::status_msg(-1,Validate::get_error(Validate::EMAIL)));
        }
    }

    public function test_arr(){
        $user_list = [
            ['id'=>1,'username'=>'zhangshan','age'=>10],
            ['id'=>2,'username'=>'lisi','age'=>20],
            ['id'=>3,'username'=>'wangwu','age'=>30],
            ['id'=>4,'username'=>'zhaoliu','age'=>40],
        ];
        echo "<pre>";
        print_r(Arr::getColumn($user_list,'id'));
        print_r(Arr::getValue($user_list[0],'useranme'));
        print_r(Arr::index($user_list,'id'));
        print_r(Arr::map($user_list,'id','username'));
    }
}