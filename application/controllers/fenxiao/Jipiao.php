<?php
namespace controllers\fenxiao;
use core\BaseController;
use models\Jipiao\Passenger;
class Jipiao extends BaseController{
    protected $render_engine= 'Smarty';
    public function index(){

        echo $this->render_engine;
        echo __METHOD__;
        $data = array(
            'test'=>100,
            'test2'=>200,
            'test3'=>300,
        );
        $this->view->assign($data);
        $this->view->display('fenxiao/jipiao_index');
    }
    public function booking(){
        echo  __METHOD__;
    }
}