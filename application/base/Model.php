<?php
namespace base;
use base\medoo;
use helpers\Arr;
class Model{
    public $db;
    protected static $table;
    protected static $pkey = 'id';
    public static $relate_models = array();
    public function __construct(){
        $this->db = Application::get_db();
    }
    
    /**
     * 处理只提供主键的情况
     *
     * @param  string|array|int $condition 条件
     * @return string|array
     */
    protected function pkey_condition($condition) {
        if (is_numeric($condition)) {  // 主键
            $condition = array(static::$pkey => $condition);
        }
        return $condition;
    }

    /***
     *  用法
     *  $passenger = $m_passenger->find(array('id'=>1),'passenger');//取某一列
     *  $passenger = $m_passenger->find(array('id'=>1));//取所有列
     * @param $where
     * @param string $fields
     * @return mixed
     */
    public function find($where, $fields = '*') {
       return $this->db->get(static::$table,$fields,$this->pkey_condition($where));
    }

    /***
     * 用法
     *   $passengers = $m_passenger->find_all(['id[>]'=>1,'LIMIT'=>10],'passenger');//取某一列
     *   $passengers = $m_passenger->find_all(['id[>]'=>1,'LIMIT'=>10]);//取所有列
     * @param $where
     * @param string $fields
     * @return mixed
     */
    public function find_all($where, $fields = '*') {
        return $this->db->select(static::$table,$fields,$where);
    }

    /**
     * 新增数据
     * @param $data 数据数组
     * @return mixed
     */
    public function insert($data) {
        return $this->db->insert(static::$table,$data);
    }

    /**
     * 修改数据
     * @param $data  数据数组
     * @param $where 条件
     * @return mixed
     */
    public function update($data,$where) {
        return $this->db->update(static::$table,$data,$where);
    }

    /**
     * 删除数据
     * @param $where 条件
     * @return mixed
     */
    public function delete($where) {
        return $this->db->delete(static::$table,$where);
    }

    /**
     * 获取列表数据
     * @param array $where
     * @param int $per_page
     * @param int $offset
     */
    public function get_list($where=array(),$fields='*'){
        $list = $this->db->select(static::$table,$fields,$where);
        return $list;
    }

    /**
     * 统计数量
     * @param array $where
     * @return mixed
     */
    public function get_total($where=array()){
        $count = $this->db->count(static::$table,$where);
        return $count;
    }
    /*
    *  获取列表关联数据
    */
    public function get_list_models(){
        //关联表id 关联后的数组健名 关联的模型名秿注意加上命名空间  取单条或者去多条
        //array('jo_id','order_psgr','models\Table\Orderpsgr','one'), 1寿
        //array('jo_id','order_psgr','models\Table\Orderpsgr','all'), 1对妅
        $relate_models = array(
            // array('jo_id','order_psgr','models\Table\Orderpsgr','all'),
            // array('jo_id','insurance','models\Table\Insurance','all'),
            // array('jo_id','order_gss','models\Table\Ordergss','all'),
        );
        return $relate_models;
    }

    /*
    * 获取详情关联模型数据
    */
    public function get_detail_models(){
        $relate_models = array(
            // array('jo_id','order_psgr','models\Table\Orderpsgr','one'),
            // array('jo_id','insurance','models\Table\Insurance','all'),
            // array('jo_id','order_gss','models\Table\Ordergss','one'),
        );
        return $relate_models;
    }

    public function get_search_models(){
        //索引的id  搜索条件 表 模型 查询类型
        $relate_search = array(
            array('id',['psgr_name','ticket_no'],'order_psgr','models\Table\Orderpsgr','all'),
        );
        return $relate_search;
    }

    /**
     * 获取关联的表数据
     * @param $ids    id数组
     * @param $relate_models 关联的模型配置数组
     * @return array
     */
    public function get_relate_data($ids,$relate_models){
        $relate_datas = array();
        foreach($relate_models as $model){
            list($relate_id,$table,$m_model,$num) = $model;
            if(!isset(self::$relate_models[$table])){
                self::$relate_models[$table] = new $m_model();//实例化关联模型
            }
            $m_data =   self::$relate_models[$table]->find_all([$relate_id=>$ids]);
            if($num=='one'){
                $m_data =  Arr::index($m_data,$relate_id);
            }else{
                $m_data =  Arr::index($m_data,$relate_id,true); 
            }
            $relate_datas[$table] = $m_data?$m_data:array();//获取关联数据
        }
        return $relate_datas;
    }

    /**
     * 获取搜索的关联数据
     * @param $params
     * @return array
     */
    public function get_search_where($params)
    {
        $search_list = $this->get_search_models(); //获取关联搜索的所有模型
        $search_where = array(); //搜索条件
        $has_where = false; //是否有条件查询
        foreach ($search_list as $model) {
            list($relate_id, $search_fields, $table, $m_model, $num) = $model;
            $where = array();
            foreach ($search_fields as $field) {
                if (isset($params[$field]) && !empty($params[$field])) {
                    $where['AND'][$field] = $params[$field];
                    $has_where = true; //是否有条件查询
                }
            }
            if (!isset(self::$relate_models[$table])) {
                self::$relate_models[$table] = new $m_model();
            }
            if (!empty($where)) {
                $m_data = self::$relate_models[$table]->find_all($where);
                $search_where = $search_where + Arr::getColumn($m_data, $relate_id);
            }
        }
        return array($has_where, $search_where);
    }

    /**
     * 填充列表数据
     * @param $lists
     * @return bool
     */
    public function fill_list(&$lists)
    {
        if (empty($lists)) {
            return false;
        }
        $ids = Arr::getColumn($lists, 'id');
        $relate_models = $this->get_list_models();
        $relate_datas = $this->get_relate_data($ids, $relate_models);
        foreach ($lists as $index => $list) {
            foreach ($relate_datas as $talbe => $data) {
                $lists[$index][$talbe] = isset($data[$list['id']]) ? $data[$list['id']] : array();
            }
        }
        // return $lists;
    }
    
    /**
     * 填充详情数据
     * @param $detail
     */
    public function fill_detail(&$detail)
    {
        $id = $detail['id'];
        $relate_models = $this->get_detail_models();
        $relate_datas = $this->get_relate_data($id, $relate_models);
        foreach ($relate_datas as $talbe => $data) {
            $detail[$talbe] = isset($data[$id]) ? $data[$id] : array();
        }
        //  return $detail;
    }

    /**
     *  填充搜索数据
     * @param $where
     * @param $params
     */
    public function fill_search(&$where, $params)
    {
        list($has_where, $where_params) = $this->get_search_where($params);
        if ($has_where) { //有条件查询的
            $where['AND']['id'] = $where_params ? $where_params : 0;
        }
    }
}
