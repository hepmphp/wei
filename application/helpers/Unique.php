<?php 
namespace helpers;
class Unique {
    /**
     * 返回全局唯一标识符GUID
     *
     * @access public
     * @static
     *
     * @return string
     */
    public static function guid() {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charId = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid   = substr($charId, 0, 8) . $hyphen
            . substr($charId, 8, 4) . $hyphen
            . substr($charId, 12, 4) . $hyphen
            . substr($charId, 16, 4) . $hyphen
            . substr($charId, 20, 12);
        return $uuid;
    }
	
	public static function order_no(){
		return date('YmdHis').mt_rand(10000,99999);
	}
	
	public static function microtime(){
		return microtime(true);
	}
	
	
	public static function salt(){
        $str = '';
        for ($i = 0; $i < 14; $i++) {
            $str .= chr(rand(48,126));  //<48有双引号和单引号
        }
        return $str;
    } 
	
}
 
