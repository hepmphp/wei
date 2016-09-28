<?php
namespace models\Logic;
use models\Table\ApiUser;
use models\Table\ApiLogin;
class Oauth {
    const ERROR_GRANT_TYPE = -100;
    const ERROR_USERNAME   = -101;
    const ERROR_PASSWORD   = -102;
    const ERROR_STATUS     = -103;
    const ERROR_IP         = -104;
    const ERROR_DB_TOKEN   = -105;
    const ERROR_PERMISSION = -106;
    const ERROR_TOKEN_NULL = -107;
    const ERROR_TOKEN      = -108;
    public static $message = array(
        self::ERROR_GRANT_TYPE=> '不支持该种验证类型',
        self::ERROR_USERNAME  => '用户名错误',
        self::ERROR_PASSWORD  => '密码错误',
        self::ERROR_STATUS    => '账户状态不可用',
        self::ERROR_IP        => '您的IP无权限访问接口',
        self::ERROR_DB_TOKEN  => 'token生成失败',
        self::ERROR_PERMISSION=>'您没有权限访问该接口',
        self::ERROR_TOKEN_NULL=>'请提供有效的token',
        self::ERROR_TOKEN      =>'token错误,请重新获取',
    );

    CONST TOKEN_KEY = '123456';//token生成秘钥
    CONST TOKEN_TIME = 86400;//token 有效期

    public $m_api_user;
    public $m_api_login;
    public function __construct(){
        $this->m_api_user = new ApiUser();
        $this->m_api_login = new ApiLogin();
    }

    public function init($controler,$action,$get_token=''){
        $token = $this->get_access_token();
        if(empty($token)){
            $token = $get_token;
        }
        //todo::validate perminssion
        $this->check_rights($controler,$action);

        return $this->validate_token($token);
    }

    public static function sucess($code=0,$data=array()){
        return array('code'=>$code,'msg'=>'','data'=>$data);
    }

    public static function error($code){
        return array('code'=>$code,'msg'=>self::$message[$code]);
    }

    public function check_rights($controler,$action){
        //
    }

    public function validate_token($token){
          if(empty($token)){
              return $this->error(Oauth::ERROR_TOKEN_NULL);
          }
          $api_login = $this->m_api_login->find(['token'=>$token]);
          if(empty($api_login)||$api_login['dateline']-time()<self::TOKEN_TIME){
              return $this->error(Oauth::ERROR_TOKEN);
          }
          return $this->sucess(0,['uid'=>$api_login['uid']]);
    }


    /**
     * @brief   get_access_token    从请求header头获取 HTTP authorization 请求头
     *
     * @Returns String|NULL
     */
    public function get_access_token() {
        $authorization = $_SERVER["HTTP_AUTHORIZATION"];
        if (!$authorization) {
            $headers = $this->apache_request_headers();
            $authorization = !empty($headers['Authorization']) ? $headers['Authorization'] : null;
        }

        if (!$authorization) {
            return null;
        }

        if (stripos($authorization, 'Bearer') !== 0) {
            return null;
        }

        return substr($authorization, strlen('Bearer '));
    }

    function apache_request_headers(){
        return array(
            'Date'=>$_SERVER["HTTP_DATE"],
            'Authorization'=>$_SERVER["HTTP_AUTHORIZATION"],
            'X-HTTP-Method-Override'=>strtolower($_SERVER["REQUEST_METHOD"]),
            'Method-Code'=>trim($_SERVER["HTTP_METHOD_CODE"])
        );
    }

    /**
     * 获取用于权限验证的 token
     *
     * @param  string $ip         IP 地址
     * @param  string $username   用户名
     * @param  string $password   密码
     * @param  string $grant_type 验证类型
     * @return array
     */
    public function get_token($ip, $username, $password, $grant_type = 'client_credentials')  {
        if(!$this->check_ip($ip)){
            return $this->error(Oauth::ERROR_IP);
        }
        if(empty($username)){
            return $this->error(Oauth::ERROR_USERNAME);
        }
        if(empty($password)){
            $this->error(Oauth::ERROR_PASSWORD);
        }
        if($grant_type!='client_credentials'){
            $this->error(Oauth::ERROR_GRANT_TYPE);
        }
        $api_user = $this->m_api_user->find(['username'=>$username]);
        if(empty($api_user)){
            $this->error(Oauth::ERROR_USERNAME);
        }

        if($api_user['password'] !=$this->gennerate_password($password,$api_user['salt'])){
            $this->error(Oauth::ERROR_PASSWORD);
        }
        $time = time();
        $api_login = $this->m_api_login->find(['AND'=>['uid'=>$api_user['uid'],'dateline[>]'=>$time-self::TOKEN_TIME]]);
        if(!empty($api_login)){
            $token = $api_login['token'];
            $dateline = $api_login['dateline'];
        }else{
            $token = hash_hmac('md5',$api_user['uid'].$time,self::TOKEN_KEY);
            $dateline = time()+self::TOKEN_TIME;
            $api_login_data = array(
                'uid'=>$api_user['uid'],
                'token'=>$token,
                'dateline'=>$dateline,
                'ip'=>$ip,
                'creation_time'=>date('Y-m-d H:i:s')
            );
            $api_login_result = $this->m_api_login->insert($api_login_data);
            if(empty($api_login_result)){
                return $this->error(Oauth::ERROR_DB_TOKEN);
            }
        }
        $token_data = array(
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => self::TOKEN_TIME,
            'expires_at'   => $dateline,
        );
        return self::sucess(0,$token_data);
    }

    public function check_ip($ip){
        //验证ip
        return true;
    }

    public function add_api_user($user_name,$password,$rights='',$allow_ip=''){
        $salt = $this->gennerate_salt();
        $data = array(
            'username'=>$user_name,
            'password'=>$this->gennerate_password($password,$salt),
            'salt'=>$salt,
            'rights'=>$rights,
            'allowed_ip'=>$allow_ip,
        );
        return $this->m_api_user->insert($data);
    }

    /**
     * @brief   gennerate_salt  取得14位随机密码盐字符串
     *
     * @Returns String
     */
    public function gennerate_salt($default_length = 14){
        $str = '';
        $default_length = (int)$default_length;
        if ($default_length > 0) {
            for ($i = 0; $i < 14; $i++) {
                $str .= chr(rand(48,126));  //<48有双引号和单引号
            }
        }

        return $str;
    }
    /**
     * @brief   gennerate_password  生成密码    = MD5( MD5(password). salt)
     *
     * @Param   $md5_pwd            第一次加密过的md5
     * @Param   $salt               随机盐
     * @Param   $const_str          其他自定义字符，暂时不用放空
     *
     * @Returns String
     */
    public function gennerate_password($pwd, $salt, $const_str = '') {
        return md5(md5($pwd). $salt. $const_str);
    }
}