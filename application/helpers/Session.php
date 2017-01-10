<?php 
namespace helpers;

class Session{
	 /**
     * @brief   diy_session_destroy     彻底注销session
     *
     * @Returns NUL   
     */
    public static function  session_destroy(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 86400, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }


    /**
     * @brief   cncn_session_start   自定义开启session
     *
     * @Param   $limiter            浏览器缓存，默认session_start()是nocache
     *
     * @Returns    
     */
    public static function  session_start($limiter = ''){
        if (session_id() == '') {
            //ini_set('session.name', 'MYSESSNAME');      //自定义session_name
            ini_set('session.cookie_httponly', 1);      //开启http-only,防止客户端js通过xss盗取cookie

            if (in_array($limiter, array('public', 'private', 'nocache', 'private_no_expire'))) {
                session_cache_limiter($limiter);        //参考:http://www.9enjoy.com/pragma-no-cache-session/
            }

            ini_set('session.gc_maxlifetime', 4*3600);    //session过期时间，启动垃圾回收机制
            session_start();
        }
    
    }
	
}