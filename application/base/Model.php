<?php
namespace base;
use base\medoo;
class Model{
    public $db;
    protected static $table;
    protected static $pkey = 'id';
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
}
