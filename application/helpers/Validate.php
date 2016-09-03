<?php
/**
 * User: fish
 * Date: 2016-08-04 00:39
 * Validate.php
 */

namespace helpers;

/**
 * Class Validate  验证静态类
 */
class Validate {
    /*防止函数输入错误*/
    CONST BASE64 = 'base64';
    CONST CHECKIDCARD='check_id_card';
    CONST CHINESE = 'chinese';
    CONST DECIMAL = 'decimal';
    CONST DATE = 'date';
    CONST EMAIL = 'email';
    CONST LENGHT ='length';
    CONST GENDER = 'gender';
    CONST GREATETHAN='greater_than';
    CONST IDCARD = 'id_card';
    CONST INARRAY = 'in_array';
    CONST INRANGE = 'in_range';
    CONST INTEGER = 'interger';
    CONST IP = 'ip';
    CONST LESSTHAN = 'less_than';
    CONST MAXLENGTH = 'max_length';
    CONST MINLENGTH = 'min_length';
    CONST MOBILE = 'mobile';
    CONST NUMERIC = 'numeric';
    CONST POSTALCODE = 'postal_code';
    CONST PRODUCTNO = 'product_no';
    CONST QQ = 'qq';
    CONST REQUIRED = 'required';
    CONST TELEPHONE = 'telephone';
    CONST TIME = 'time';
    CONST URL = 'url';

    public $param = array();
    public $rules = array();
    public $error_list = array();
    public function set_param($param,$rules){
        $this->param = $param;
        $this->rules = $rules;
    }
    public function validate(){
        foreach($this->param as $key=>$value){
            $call_back = $this->rules[$key][0];//验证的回调函数
            $error_msg = $this->rules[$key][1];//错误消息
            $code      = $this->rules[$key][2];//错误代码
            $data      = $this->rules[$key][3];//参数
            if(!call_user_func_array(array(__NAMESPACE__ .'\Validate', $call_back), array($value,$data))){
                $this->set_error($error_msg,$code);
            }
        }
        if(empty($this->error_list)){
            return true;
        }else{
            return false;
        }
    }
    public function set_error($msg,$status=-1){
        array_unshift($this->error_list,array('status'=>$status,'msg'=>$msg));
    }
    public  function get_error($first=true){
        return $first?array_pop($this->error_list):$this->error_list;
    }

    static function check_id_card($idcard){
        // 只能是18位
        if(strlen($idcard)!=18){
            return false;
        }
        // 取出本体码
        $idcard_base = substr($idcard, 0, 17);

        // 取出校验码
        $verify_code = substr($idcard, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // 根据前17位计算校验码
        $total = 0;
        for($i=0; $i<17; $i++){
            $total += substr($idcard_base, $i, 1)*$factor[$i];
        }
        // 取模
        $mod = $total % 11;
        // 比较校验码
        if($verify_code == $verify_code_list[$mod]){
            return true;
        }else{
            return false;
        }
    }
    /**
     *  检查日期 xxxx-xx-xx
     */
    public static function date($date = ''){
        return preg_match('/^[\d]{4}\-[\d]{1,2}-[\d]{1,2}$/', $date);
    }
    /**
     *  检查完整日期 xxxx-xx-xx xx:xx:xx
     */
    public static function time($date = ''){
        return preg_match('/^[\d]{4}\-[\d]{1,2}-[\d]{1,2} [\d]{1,2}:[\d]{1,2}:[\d]{1,2}$/', $date);
    }
    /**
     *  检查手机号码
     */
    public static  function mobile($mobile = ''){
        return preg_match("/^1[3|4|5|7|8][0-9]\d{8}$/", $mobile);
    }
    /**
     *  检查email格式
     */
    public static function email($email = ''){
        return preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
    }
    /**
     *  检查邮政编码
     */
    public static function postal_code($postal_code = ''){
        return preg_match("/[1-9]{1}(\d+){5}/", $postal_code);
    }
    /**
     *  检查ipv4 地址
     */
    public static function ip($ip){
        return preg_match("/(\d+){1,3}\.(\d+){1,3}\.(\d+){1,3}\.(\d+){1,3}/", $ip);
    }
    /**
     *  检查qq号码
     */
    public static  function qq($qq = ''){
        return preg_match("/^[1-9](\d){4,11}$/", $qq);
    }
    /**
     *  检查身份证号码
     */
    public static  function id_card($id_card = ''){
        return ( preg_match("/^\d{17}(\d|x)$/i", $id_card) || preg_match("/^\d{15}$/i", $id_card) );
    }
    /**
     *  检查性别
     */
    public static function gender($gender){
        return in_array($gender, array(0, 1));
    }
    /**
     *  检查产品编号
     */
    public static function product_no($product_no = ''){
        return preg_match('/^[0-9a-zA-Z-]{1,16}$/', $product_no);
    }
    /**
     *  检查电话号码
     */
    public static function telephone($telephone = ''){
        return preg_match( "/^[\d]+[\d-]*[\d]$/", $telephone);
    }
    /**
     *  url地址(简单检查是否以http://开头)
     */
    public static function url($url = ''){
        return preg_match('/^http[s]?:\/\/.*?/i', $url);
    }
    /**
     *  检查是否全中文
     *  ------------------------------
    中文双字节字符编码范围
    1. GBK (GB2312/GB18030)
    x00-xff GBK双字节编码范围
    x20-x7f ASCII
    xa1-xff 中文 gb2312
    x80-xff 中文 gbk
    2. UTF-8 (Unicode)
    u4e00-u9fa5 (中文)
    x3130-x318F (韩文
    xAC00-xD7A3 (韩文)
    u0800-u4e00 (日文)
     */
    public static function chinese($str){
        //return preg_match('/^[\xa1-\xff]+$/', $str);
        return preg_match('/^[\x80-\xff]+$/', $str);
    }
    public static function required($str)
    {
        if ( ! is_array($str))
        {
            return (trim($str) == '') ? FALSE : TRUE;
        }
        else
        {
            return ( ! empty($str));
        }
    }
    public static function min_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val))
        {
            return FALSE;
        }
        if (function_exists('mb_strlen'))
        {
            return (mb_strlen($str) < $val) ? FALSE : TRUE;
        }
        return (strlen($str) < $val) ? FALSE : TRUE;
    }
    public static function max_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val))
        {
            return FALSE;
        }
        if (function_exists('mb_strlen'))
        {
            return (mb_strlen($str) > $val) ? FALSE : TRUE;
        }
        return (strlen($str) > $val) ? FALSE : TRUE;
    }
    public static function length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val))
        {
            return FALSE;
        }
        if (function_exists('mb_strlen'))
        {
            return (mb_strlen($str) != $val) ? FALSE : TRUE;
        }
        return (strlen($str) != $val) ? FALSE : TRUE;
    }

    public static function numeric($str)
    {
        return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }
    public static function is_numeric($str)
    {
        return ( ! is_numeric($str)) ? FALSE : TRUE;
    }
    public static function integer($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
    }
    public static function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }
    public static  function greater_than($str, $min)
    {
        if ( ! is_numeric($str))
        {
            return FALSE;
        }
        return $str > $min;
    }
    public static function less_than($str, $max)
    {
        if ( ! is_numeric($str))
        {
            return FALSE;
        }
        return $str < $max;
    }
    public static function in_range()
    {
        $args = func_get_args();
        $num = $args[0];
        $min = $args[1][0];
        $max = $args[1][1];
        return self::less_than($num,$max)&&self::greater_than($num,$min);
    }
    public static function base64($str)
    {
        return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
    }
    public static function in_array($search,$dataArr)
    {
        return in_array($search,$dataArr);
    }
}
/**

 if(!Validate::date($data['id'])){
    print_r(Msg::status_msg(ErrorCode::DB,Validate::get_error(Validate::DATE)));
  }

   $data = array(
    'base'=>1,
    'check_id_card'=>'35052119900',
    'chinese'=>'124',
    'decimal'=>'12',
    'email'=>'hepm',
    'length'=>123,
    'gender'=>3,
    'gt'=>120,
    'inarr'=>2,
    'ir'=>1,
    'int'=>'1',
    'ip'=>'127.0.01',
    'ml'=>'11111111111111111111111111111111111111111111111',
    'minl'=>'1',
    'mobile'=>'15210',
    'numeric'=>'12a',
    'qq'=>'123',
    'required'=>'1',
    'date'=>'aaa',
    'time'=>'aaa',
    'url'=>'url',
);
$validate_rules = [
    '字段名'=>['验证器','验证提示信息','错误代码','额外参数']
    'base'         =>[Validate::BASE64,'base64错误',-1],
    'check_id_card'=>[Validate::CHECKIDCARD,'身份证号码错误',-2],
    'chinese'      =>[Validate::CHINESE,'姓名输入的必须是中文',-3],
    'decimal'      =>[Validate::DECIMAL,'必须是小数',-4],
    'email'        =>[Validate::EMAIL,'邮箱格式错误',-5],
    'length'       =>[Validate::LENGHT,'长度不能超过10',-6,10],
    'gender'       =>[Validate::GENDER,'性别错误',-7],
    'gt'           =>[Validate::GREATETHAN,'数字必须大于100',-8,100],
    'inarr'        =>[Validate::INARRAY,'值必须在范围内2,3,4,5',-9,[2,3,4,5]],
    'ir'           =>[Validate::INRANGE,'值必须在90,100之间',-10,[90,10]],
    'int'          =>[Validate::INTEGER,'值必须是整形',-11],
    'ip'           =>[Validate::IP,'ip错误',-12],
    'ml'           =>[Validate::MAXLENGTH,'最长不能超过15',-13,15],
    'minl'         =>[Validate::MINLENGTH,'最小不能小于2个字符',-14,2],
    'mobile'       =>[Validate::MOBILE,'手机号码错误',-15],
    'numeric'      =>[Validate::NUMERIC,'必须是数值型',-16],
    'qq'           =>[Validate::QQ,'qq错误',-17],
    'required'     =>[Validate::REQUIRED,'字段不能为空',-18],
    'date'         =>[Validate::DATE,'日期格式错误',-19],
    'time'         =>[Validate::TIME,'时间格式错误',-20],
    'url'          =>[Validate::URL,'url格式错误',-21],
];
$validate = new Validate();
$validate->set_param($data,$validate_rules);
if(!$validate->validate()){
    echo "<pre>";
    print_r($validate->get_error(false));
}
 */
