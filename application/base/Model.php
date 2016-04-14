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

    /**
     * 获取一行数据
     *
     * @param string|array|int $condition 条件
     * @param string           $fields    要取的字段
     * @param array            $criteria  其他查询条件 (order by, group by, having)
     * @param null|int|array   $limit     LIMIT 条件
     * @return array
     */
    public function find($condition, $fields = '*') {
       return $this->db->get(static::$table,$fields,null,$this->pkey_condition($condition));
    }

    /**
     * 获取所有数据
     *
     * @param string|array|int $condition 条件
     * @param string           $fields    要取的字段
     * @param array            $criteria  其他查询条件 (order by, group by, having)
     * @param null|int|array   $limit     LIMIT 条件
     * @return array
     */
    public function find_all($condition, $fields = '*', $criteria = array(), $limit = null) {
        $sql = $this->db->select_string($fields, static::$table,
            $this->pkey_condition($condition), $limit, $criteria);
        return $this->db->get_rows($sql);
    }

    /**
     * 获取一列数据
     *
     * @param string|array|int $condition 条件
     * @param string|int       $column    要返回的列键值
     * @param array            $criteria  其他查询条件 (order by, group by, having)
     * @param null|int|array   $limit     LIMIT 条件
     * @return array
     */
    public function find_column($condition, $column = 0, $criteria = array(), $limit = null) {
        $fields = is_int($column) ? '*' : $column;
        $sql = $this->db->select_string($fields, static::$table,
            $this->pkey_condition($condition), $limit, $criteria);
        return $this->db->get_column($sql, $column);
    }

    /**
     * 获取第一行数据的第一列
     *
     * @param string|array|int $condition 条件
     * @param string|int       $field     要取的字段
     * @param array            $criteria  其他查询条件 (order by, group by, having)
     * @param null|int|array   $limit     LIMIT 条件
     * @return mixed
     */
    public function find_value($condition, $field = '*', $criteria = array(), $limit = null) {
        $sql = $this->db->select_string($field, static::$table,
            $this->pkey_condition($condition), $limit, $criteria);
        return $this->db->get_value($sql);
    }

    /**
     * 获取第一行数据的第一列
     *
     * @param string           $field     要取的字段
     * @param string|array|int $condition 条件
     * @param null|int|array   $limit     LIMIT 条件
     * @param array            $criteria  其他查询条件 (order by, group by, having)
     * @return mixed
     */
    public function value($field, $condition, $limit = null, $criteria = array()) {
        $sql = $this->db->select_string($field, static::$table,
            $this->pkey_condition($condition), $limit, $criteria);
        return $this->db->get_value($sql);
    }

    /**
     * 添加数据
     *
     * @param array $data
     * @return int|false 成功返回 ID 主键，失败返回 false
     */
    public function add($data) {
        $result = $this->db->insert(static::$table, $data);
        if (!$result) {
            return false;
        }

        return $this->db->insert_id();
    }

    /**
     * 修改数据
     *
     * @param  string|array|int $condition 条件
     * @param  array            $data
     * @param  bool|int         $limit LIMIT 条件
     * @return bool 成功返回 true，失败返回 false
     */
    public function edit($condition, $data, $limit = false) {
        return $this->db->update(static::$table, $data,
            $this->pkey_condition($condition), $limit);
    }

    /**
     * 删除数据
     *
     * @param string|array|int $condition 查询条件
     * @param bool|false       $limit     LIMIT 条件
     * @return mixed
     */
    public function remove($condition, $limit = true) {
        return $this->db->delete(static::$table,
            $this->pkey_condition($condition), $limit);
    }


}