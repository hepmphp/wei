<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ok_fish
 * Date: 18-5-14
 * Time: 下午1:46
 * To change this template use File | Settings | File Templates.
 */
namespace base\db;
use Pdo;

class PdoHelper
{
    private $host = '127.0.0.1';
    private $dbname = 'game_admin';
    private $username = 'root';
    private $password = '123456';
    private $port = 3306;
    private $charset = 'utf8';
    public static $pdo = null;
    /*存储对象的实例*/
    private static $_instances = array();
    public static function getInstance($configs = null)
    {
        $instance = new self($configs);
        return $instance;
    }
    public function __construct($configs = null)
    {
        if (is_array($configs)) {
            foreach ($configs as $option => $value) {
                $this->$option = $value;
            }
        }
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset};";
        self::$pdo = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_PERSISTENT => true));
    }
    public function fetch($sql)
    {
        return self::$pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function fetchAll($sql)
    {
        return self::$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function exec($sql)
    {
        return self::$pdo->exec($sql);
    }

    public function lastInsertId(){
        return self::$pdo->lastInsertId();
    }

    public function quote($str){
        return self::$pdo->quote($str);
    }
}