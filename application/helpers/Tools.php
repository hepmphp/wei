<?php
namespace helpers;
/*
 *      $db = base\Application::get_db();
        Tools::tables_to_model($db);
 */
class Tools{

    /**
     * 通用表模型生成工具
     * @param $db
     */
    public static  function tables_to_model($db){
        $db_name = 'jipiao';
        $tables_path = APP_PATH.'/models/Table/';
        $db->query("USE {$db_name}");
        $result = $db->query("show tables")->fetchAll();
        $all_tables = Arr::getColumn($result,'0');
        foreach($all_tables as $table){
            $model_table = str_replace(' ','',ucwords(str_replace(array('_'),array('',' '),strstr($table,'_'))));
            $template    = file_get_contents($tables_path.'Template.php');
            $model_data  = str_replace(array('Template','TABLE'),array($model_table,$db_name.'.'.$table),$template);
            $file_name   = $tables_path.$model_table.'.php';
            file_put_contents($file_name,$model_data);
        }
    }
}