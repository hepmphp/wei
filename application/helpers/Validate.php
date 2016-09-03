<?php
/**
 * User: fish
 * Date: 2016-08-04 00:39
 * Validate.php
 */

namespace helpers;

/**
 * Class Validate  ��֤��̬��
 */
class Validate {
    /*��ֹ�����������*/
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
            $call_back = $this->rules[$key][0];//��֤�Ļص�����
            $error_msg = $this->rules[$key][1];//������Ϣ
            $code      = $this->rules[$key][2];//�������
            $data      = $this->rules[$key][3];//����
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
        // ֻ����18λ
        if(strlen($idcard)!=18){
            return false;
        }
        // ȡ��������
        $idcard_base = substr($idcard, 0, 17);

        // ȡ��У����
        $verify_code = substr($idcard, 17, 1);

        // ��Ȩ����
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        // У�����Ӧֵ
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        // ����ǰ17λ����У����
        $total = 0;
        for($i=0; $i<17; $i++){
            $total += substr($idcard_base, $i, 1)*$factor[$i];
        }
        // ȡģ
        $mod = $total % 11;
        // �Ƚ�У����
        if($verify_code == $verify_code_list[$mod]){
            return true;
        }else{
            return false;
        }
    }
    /**
     *  ������� xxxx-xx-xx
     */
    public static function date($date = ''){
        return preg_match('/^[\d]{4}\-[\d]{1,2}-[\d]{1,2}$/', $date);
    }
    /**
     *  ����������� xxxx-xx-xx xx:xx:xx
     */
    public static function time($date = ''){
        return preg_match('/^[\d]{4}\-[\d]{1,2}-[\d]{1,2} [\d]{1,2}:[\d]{1,2}:[\d]{1,2}$/', $date);
    }
    /**
     *  ����ֻ�����
     */
    public static  function mobile($mobile = ''){
        return preg_match("/^1[3|4|5|7|8][0-9]\d{8}$/", $mobile);
    }
    /**
     *  ���email��ʽ
     */
    public static function email($email = ''){
        return preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
    }
    /**
     *  �����������
     */
    public static function postal_code($postal_code = ''){
        return preg_match("/[1-9]{1}(\d+){5}/", $postal_code);
    }
    /**
     *  ���ipv4 ��ַ
     */
    public static function ip($ip){
        return preg_match("/(\d+){1,3}\.(\d+){1,3}\.(\d+){1,3}\.(\d+){1,3}/", $ip);
    }
    /**
     *  ���qq����
     */
    public static  function qq($qq = ''){
        return preg_match("/^[1-9](\d){4,11}$/", $qq);
    }
    /**
     *  ������֤����
     */
    public static  function id_card($id_card = ''){
        return ( preg_match("/^\d{17}(\d|x)$/i", $id_card) || preg_match("/^\d{15}$/i", $id_card) );
    }
    /**
     *  ����Ա�
     */
    public static function gender($gender){
        return in_array($gender, array(0, 1));
    }
    /**
     *  ����Ʒ���
     */
    public static function product_no($product_no = ''){
        return preg_match('/^[0-9a-zA-Z-]{1,16}$/', $product_no);
    }
    /**
     *  ���绰����
     */
    public static function telephone($telephone = ''){
        return preg_match( "/^[\d]+[\d-]*[\d]$/", $telephone);
    }
    /**
     *  url��ַ(�򵥼���Ƿ���http://��ͷ)
     */
    public static function url($url = ''){
        return preg_match('/^http[s]?:\/\/.*?/i', $url);
    }
    /**
     *  ����Ƿ�ȫ����
     *  ------------------------------
    ����˫�ֽ��ַ����뷶Χ
    1. GBK (GB2312/GB18030)
    x00-xff GBK˫�ֽڱ��뷶Χ
    x20-x7f ASCII
    xa1-xff ���� gb2312
    x80-xff ���� gbk
    2. UTF-8 (Unicode)
    u4e00-u9fa5 (����)
    x3130-x318F (����
    xAC00-xD7A3 (����)
    u0800-u4e00 (����)
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
    '�ֶ���'=>['��֤��','��֤��ʾ��Ϣ','�������','�������']
    'base'         =>[Validate::BASE64,'base64����',-1],
    'check_id_card'=>[Validate::CHECKIDCARD,'���֤�������',-2],
    'chinese'      =>[Validate::CHINESE,'��������ı���������',-3],
    'decimal'      =>[Validate::DECIMAL,'������С��',-4],
    'email'        =>[Validate::EMAIL,'�����ʽ����',-5],
    'length'       =>[Validate::LENGHT,'���Ȳ��ܳ���10',-6,10],
    'gender'       =>[Validate::GENDER,'�Ա����',-7],
    'gt'           =>[Validate::GREATETHAN,'���ֱ������100',-8,100],
    'inarr'        =>[Validate::INARRAY,'ֵ�����ڷ�Χ��2,3,4,5',-9,[2,3,4,5]],
    'ir'           =>[Validate::INRANGE,'ֵ������90,100֮��',-10,[90,10]],
    'int'          =>[Validate::INTEGER,'ֵ����������',-11],
    'ip'           =>[Validate::IP,'ip����',-12],
    'ml'           =>[Validate::MAXLENGTH,'����ܳ���15',-13,15],
    'minl'         =>[Validate::MINLENGTH,'��С����С��2���ַ�',-14,2],
    'mobile'       =>[Validate::MOBILE,'�ֻ��������',-15],
    'numeric'      =>[Validate::NUMERIC,'��������ֵ��',-16],
    'qq'           =>[Validate::QQ,'qq����',-17],
    'required'     =>[Validate::REQUIRED,'�ֶβ���Ϊ��',-18],
    'date'         =>[Validate::DATE,'���ڸ�ʽ����',-19],
    'time'         =>[Validate::TIME,'ʱ���ʽ����',-20],
    'url'          =>[Validate::URL,'url��ʽ����',-21],
];
$validate = new Validate();
$validate->set_param($data,$validate_rules);
if(!$validate->validate()){
    echo "<pre>";
    print_r($validate->get_error(false));
}
 */
