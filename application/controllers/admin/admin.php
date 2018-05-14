<?php 

namespace controllers\admin;
use base\BaseController;

class Admin extends BaseController{
    protected $render_engine= 'php';
    public function index(){
		$this->view->assign('content','index');
        $this->view->display('test/admin_index');
    }
	
	public function login(){
		$this->view->assign('content','login');
        $this->view->display('test/admin_login');
	}

  
}