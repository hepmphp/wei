<?php
namespace base;
class SmartyView implements ViewInterface {

    protected $tpl_ext = 'php';

    protected $smarty = null;

    public function __construct($view_path) {

        $this->smarty = new \Smarty;
        $this->smarty->debugging = false;
        $this->smarty->caching = true;
        $this->smarty->cache_lifetime = 120;
        $this->smarty->template_dir = $view_path;
      //  $this->smarty->cache_dir = $view_path.'/cache/';

    }

    public function assign($name, $value = null) {
        $this->smarty->assign($name, $value);
    }


    public function display($template, $cache_id = null, $compile_id = null,$parent=null) {
        $this->smarty->display($template.'.'.$this->tpl_ext, $cache_id, $compile_id, $parent);
    }

    /**
     * executes & returns or displays the template results
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param bool   $display
     * @return mixed
     */
    public function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false) {
        return $this->smarty->fetch($resource_name . '.' . $this->tpl_ext, $cache_id, $compile_id, $display);
    }
}