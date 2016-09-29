<?php
namespace controllers;
use base\BaseController;
use helpers\Debug;
use helpers\Email;
use helpers\ErrorCode;
use helpers\Msg;
use helpers\Tools;
use helpers\Validate;
use helpers\Arr;
use helpers\Ftp;

class Welcome extends BaseController{
	public $render_engine = 'php';
	
    public function index(){
        echo "<pre>";
        Debug::print_stack_trace();
    }
    public function trigger_error(){
       // trigger_error('hello');
        $a['a'] = 0;
        var_dump($a['b']);
    }

   



    public function ftp(){
          var_export(Ftp::getInstance()->list_files());
      //  Ftp::getInstance()->mk_subdirs()
    //    $mkdirStatus = $this->ftp->ftp_mksubdirs('',$rometeFileDir);
      //  $this->ftp->upload($localFile,$remoteFile)
           
       
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
            'base'=>'',
            'check_id_card'=>'',
            'chinese'=>'124',
            'decimal'=>'12',
            'email'=>'hepm',
            'length'=>123,
            'gender'=>3,
            'gt'=>99,
            'inarr'=>1,
//            'ir'=>1,
//            'int'=>'1',
//            'ip'=>'127.0.01',
//            'ml'=>'11111111111111111111111111111111111111111111111',
//            'minl'=>'1',
//            'mobile'=>'15210',
//            'numeric'=>'12a',
//            'qq'=>'123',
//            'required'=>'1',
//            'date'=>'aaa',
//            'time'=>'aaa',
//            'url'=>'url',
        );
        $validate_rules = [
            'base'         =>[[Validate::BASE64,'输入的字段不能为空'],[Validate::REQUIRED,'输入的字段不能为空']],
            'check_id_card'=>[[Validate::REQUIRED],[Validate::CHECKIDCARD]],
            'chinese'      =>[Validate::CHINESE],
            'decimal'      =>[Validate::DECIMAL],
            'email'        =>[Validate::EMAIL],
            'length'       =>[Validate::LENGTH,'','',10],
            'gender'       =>[Validate::GENDER],
            'gt'           =>[Validate::GREATETHAN,'','',100],
            'inarr'        =>[Validate::INARRAY,'','',[2,3,4,5]],
//            'ir'           =>[Validate::INRANGE,'值必须在90,100之间',-10,[90,10]],
//            'int'          =>[Validate::INTEGER,'值必须是整形',-11],
//            'ip'           =>[Validate::IP,'ip错误',-12],
//            'ml'           =>[Validate::MAXLENGTH,'最长不能超过15',-13,15],
//            'minl'         =>[Validate::MINLENGTH,'最小不能小于2个字符',-14,2],
//            'mobile'       =>[Validate::MOBILE,'手机号码错误',-15],
//            'numeric'      =>[Validate::NUMERIC,'必须是数值型',-16],
//            'qq'           =>[Validate::QQ,'qq错误',-17],
//            'required'     =>[Validate::REQUIRED,'字段不能为空',-18],
//            'date'         =>[Validate::DATE,'日期格式错误',-19],
//            'time'         =>[Validate::TIME,'时间格式错误',-20],
//            'url'          =>[Validate::URL,'url格式错误',-21],
        ];
        $validate = new Validate($data,$validate_rules);
        if(!$validate->validate()){
            echo "<pre>";
            print_r($validate->get_error(false));
        }

        /*
       if(!Validate::date($data['id'])){
            print_r(Msg::status_msg(ErrorCode::DB,Validate::get_error(Validate::DATE)));
       }
       if(!Validate::email($data['id'])){
           print_r(Msg::status_msg(-1,Validate::get_error(Validate::EMAIL)));
        }
        */
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