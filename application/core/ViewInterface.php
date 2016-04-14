<?php
namespace core;
Interface ViewInterface {
    public function assign($name,$value=null);
    public function display($view_file);
}