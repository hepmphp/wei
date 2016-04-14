<?php
namespace core;
class PhpView implements ViewInterface {

    protected $view_path = '';
    protected $vars;

    public function __construct($view_path) {
        $this->view_path = $view_path;
    }


    public function assign($name, $value = null) {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->vars[$k] = $v;
            }
        } else {
            $this->vars[$name] = $value;
        }

        return $this;
    }

    public function display($view_file) {
        $old_path = getcwd();
        chdir($this->view_path);

        extract($this->vars);
        include "$view_file.php";

        chdir($old_path);
    }
}