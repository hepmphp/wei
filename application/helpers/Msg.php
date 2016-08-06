<?php

namespace helpers;
/**
 *
 * 统一消息返回
 * Class Msg
 * @package helpers
 */

class Msg {


    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return void|string
     */
    public static function dump($var, $echo=true, $label=null, $strict=true) {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }

    /**
     * @brief   exit_msg    返回消息
     *
     * @Param   $msg        提示消息
     * @Param   $res        0失败   1成功
     * @Param   $data       返回的数据
     * @Param   $exit_flag  是否立即退出,fastcgi_finish_request应用场景
     *
     * @Returns NULL
     */
    public static function exit_msg($msg, $status = 0,$data='', $exit_flag=true){
        $res = array(
            'status'=>$status,
            'msg'=>$msg,
            'data'=>$data,
        );
        header('Content-type:application/x-javascript');
        if ($exit_flag) {
            exit(self::cncn_json_encode($res));
        } else {
            echo self::cncn_json_encode($res);
        }
    }
    public static function cncn_json_encode($data) {
        return json_encode(Encoding::g2u($data));
    }
    /**
     *判断是否是异步请求
     * @return bool
     */
    public static function is_ajax(){
        $r = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : '';
        return $r == 'xmlhttprequest';
    }
    public static  function show_msg($msg, $url = "") {
        echo "<script type=\"text/javascript\">";
        if (strlen($msg) > 1) {
            echo "alert(\"$msg\");";
        }
        if ($url == "") {
            echo "history.go(-1);";
        } else {
            echo "document.location.href='$url';";
        }
        echo "</script>";
        exit();
    }
    public static function cncn_exit($msg,$url){
        if(self::is_ajax()){
            self::exit_msg($msg);
        }else{
            self::show_msg($msg,$url);
        }
    }

    public static function status_msg($status,$msg){
        return array('status'=>$status,'msg'=>$msg);
    }

    public static function is_error($msg){
        if($msg['status']===0){
            return false;
        }else{
            return true;//是错误
        }
    }

}
