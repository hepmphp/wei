<?php
/**
 * User: fish
 * Date: 2016-08-04 00:39
 * Validate.php
 */

namespace helpers;

/***
 * if(!Validate::date($data['id'])){
        print_r(Msg::status_msg(ErrorCode::DB,Validate::get_error(Validate::DATE)));
   }

 if(!Validate::email($data['id'])){
           print_r(Msg::status_msg(-1,Validate::get_error(Validate::EMAIL)));
  }
 */
/**
 * Class Validate  ��֤��̬��
 */
class Validate{
    CONST EXTEND    =    'extraValidate'; //��չ����֤
    CONST CALLBACK  =    'callback';     //ʹ��callback�����֤
    CONST DATE      =    'date';
    CONST TIME      =   'time';
    CONST MOBILE    =   'mobile';
    CONST EMAIL     =   'email';
    CONST POST_CODE =   'ppostalCode';
    CONST IP        =   'ip';
    CONST QQ        =   'qq';
    CONST ID_CART   =   'id_card';
    CONST TELEPHONE =   'telephone';
    CONST URL       =   'url';
    CONST REQUIRED  =   'required';
    CONST NUMBERNIC =   'numeric';
    CONST INTEGER   =   'integer';
    CONST INARRAY   =   'inArray';
    CONST INRANGE   =   'inRange';
    public  static $errorMessage = array(
        self::DATE    =>    '���ڸ�ʽ����',
        self::TIME    =>    'ʱ���ʽ����',
        self::MOBILE  =>    '�ֻ���ʽ����',
        self::EMAIL   =>    '�����ʽ����',
        self::POST_CODE =>  '�����������',
        self::IP       =>   'IP��ʽ����',
        self::QQ       =>   'QQ��ʽ����',
        self::ID_CART  =>   '����˺Ÿ�ʽ����',
        self::TELEPHONE=>   '�绰�������',
        self::URL      =>   'URL��ַ����',
        self::REQUIRED =>   '�ֶα���',
        self::NUMBERNIC =>  '��ֵ����',
        self::INTEGER   =>  '����Ϊ����',
        self::INARRAY     =>'������Χ',
        self::INRANGE     =>'������Χ',
    );

    public static function get_error($type){
        return self::$errorMessage[$type];
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
    public static function postalCode($postal_code = ''){
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
    /**
     * Required
     *
     * @access	public
     * @param	string
     * @return	bool
     */
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
    /**
     * Minimum Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public static function minLength($str, $val)
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
    // --------------------------------------------------------------------
    /**
     * Max Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public static function maxLength($str, $val)
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
    // --------------------------------------------------------------------
    /**
     * Exact Length
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public static function exactLength($str, $val)
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
    // --------------------------------------------------------------------
    /**
     * Numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function numeric($str)
    {
        return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
    }
    // --------------------------------------------------------------------
    /**
     * Is Numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function isNumeric($str)
    {
        return ( ! is_numeric($str)) ? FALSE : TRUE;
    }
    // --------------------------------------------------------------------
    /**
     * Integer
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function integer($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+$/', $str);
    }
    // --------------------------------------------------------------------
    /**
     * Decimal number
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }
    // --------------------------------------------------------------------
    /**
     * Greather than
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static  function greaterThan($str, $min)
    {
        if ( ! is_numeric($str))
        {
            return FALSE;
        }
        return $str > $min;
    }
    // --------------------------------------------------------------------
    /**
     * Less than
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function lessThan($str, $max)
    {
        if ( ! is_numeric($str))
        {
            return FALSE;
        }
        return $str < $max;
    }
    public static function inRange()
    {
        $args = func_get_args();
        $num = $args[0];
        $min = $args[1][0];
        $max = $args[1][1];
        return self::lessThan($num,$max)&&self::greaterThan($num,$min);
    }
    /**
     * Valid Base64
     *
     * Tests a string for characters outside of the Base64 alphabet
     * as defined by RFC 2045 http://www.faqs.org/rfcs/rfc2045
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public static function base64($str)
    {
        return (bool) ! preg_match('/[^a-zA-Z0-9\/\+=]/', $str);
    }
    public static function inArray($search,$dataArr)
    {
        return in_array($search,$dataArr);
    }
}