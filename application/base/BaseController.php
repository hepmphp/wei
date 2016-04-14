<?php
namespace base;

abstract class BaseController{

    protected $render_engine = 'Smarty';

    protected $view;


    public function __construct() {
        $this->make_view();
    }

    protected function make_view() {
        if (!$this->render_engine) {
            return;
        }

        $view_path = APP_PATH.'/views/';
        if ($this->render_engine === 'Smarty') {
            $smarty_view          = new SmartyView($view_path);
            $this->view           = $smarty_view;
        } else {
            $this->view = new PhpView($view_path);
        }
    }

}