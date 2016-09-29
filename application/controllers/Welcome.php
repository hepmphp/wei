<?php
namespace controllers;
use base\Application;
use base\BaseController;

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
class Welcome extends BaseController{
	public $render_engine = 'php';


    public function add_user(){
        $user = 'test';
        $pass = '123456';
        $m_oauth = new Oauth();
        $result = $m_oauth->add_api_user($user,$pass);
        var_dump($result);
    }

    public function http_get(){
        $url = 'http://127.0.0.1/test/wei/public/index.php/auth/get_access_token';
        $token_data = Http::client()->debug(2)->auth_basic('test','123456')->get($url, array('grant_type' => 'client_credentials'))->json();
        $url2 = 'http://127.0.0.1/test/wei/public/index.php/auth/init';
        $result = Http::client()->debug(2)
                                ->auth_bearer($token_data['data']['access_token'])
                                ->get($url2)
                                ->json();
        var_dump($token_data);
        var_dump($result);
        var_dump(Http::client()->print_last_log());

    }
    public function queue(){

        $a = array(
            'id'=>microtime(true),
            'time'=>time(),
            'cid'=>7613,
            'message'=>'this is a message',
        );
        array_push($GLOBALS['list'],$a);
        var_dump($GLOBALS['list']);
        //Queue::push($a);

    }

    public function queue1(){
        var_dump(Queue::$queue_list);
        $a = array(
            'id'=>microtime(true),
            'time'=>time(),
            'cid'=>7613,
            'message'=>'this is a message',
        );
        Queue::push($a);
        var_dump(Queue::$queue_list);
    }


    public function index(){
         $db = Application::get_db('slave');
         $passengers = $db->get('jp_passenger','*');
         var_dump($passengers);
//        echo "<pre>";
//        Debug::print_stack_trace();
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

    public function table(){
        $db = \base\Application::get_db();
        Tools::tables_to_model($db);
    }


}