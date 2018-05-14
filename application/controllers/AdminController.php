<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ok_fish
 * Date: 18-5-14
 * Time: 下午2:26
 * To change this template use File | Settings | File Templates.
 */

namespace controllers;

use base\BaseController;
use base\Application;
use base\db\QueryBuilder;

//数据库便捷操作
function D($table_name,$master='master'){
    $config = Application::getInstance()->config['database'][$master];
    return QueryBuilder::getInstance($config)->table($table_name);
}

class AdminController extends BaseController{

    public function __construct(){
        parent::__construct();
    }






}