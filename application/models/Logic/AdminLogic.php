<?php
use models\Admin;

/**
 * 后台管理逻辑层
 * Class AdminLogic
 */
class AdminLogic {
    public $m_admin_user;
    public function __construct(){
        $this->m_admin_user = new AdminUser();
    }

    public function verify(){

    }

    public function login(){

    }
    public function logout(){

    }
    public function check_login_status()
    {
    }
    public function check_permission(){

    }

    public function add_login_log(){

    }

    public function add_admin($data){
        return $this->m_admin_user->insert($data);
    }
    public function del_admin($where){
        return $this->m_admin_user->delete($where);
    }
    public function update_admin($data,$where){
        return $this->m_admin_user->update($data,$where);
    }

}