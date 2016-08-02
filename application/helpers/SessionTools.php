<?php 
namespace helper;
class SessionTools{
	 /**
     * @brief   diy_session_destroy     ����ע��session
     *
     * @Returns NUL   
     */
    public function static session_destroy(){
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 86400, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        $this->cncn_exit('��¼�ѹ��ڣ���ˢ�����µ�¼');
    }


    /**
     * @brief   cncn_session_start   �Զ��忪��session
     *
     * @Param   $limiter            ��������棬Ĭ��session_start()��nocache
     *
     * @Returns    
     */
    public function static session_start($limiter = ''){
        if (session_id() == '') {
            //ini_set('session.name', 'MYSESSNAME');      //�Զ���session_name
            ini_set('session.cookie_httponly', 1);      //����http-only,��ֹ�ͻ���jsͨ��xss��ȡcookie

            if (in_array($limiter, array('public', 'private', 'nocache', 'private_no_expire'))) {
                session_cache_limiter($limiter);        //�ο�:http://www.9enjoy.com/pragma-no-cache-session/
            }

            ini_set('session.gc_maxlifetime', 4*3600);    //session����ʱ�䣬�����������ջ���
            session_start();
        }
    
    }
	
}