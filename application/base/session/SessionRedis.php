<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ok_fish
 * Date: 18-5-14
 * Time: 下午3:15
 * To change this template use File | Settings | File Templates.
 */

namespace base\session;

use helpers\Cache\CacheRedis;
use base\Application;

/**
 * redis session
 * Class SessionRedis
 */
class SessionRedis {

    public $prefix = 'wei_session';
    /**
     * Session有效时间
     */
    protected $lifeTime      = '';


    /**
     * 数据库句柄
     */
    protected $redis  = array();

    /**
     * 打开Session
     * @access public
     * @param string $savePath
     * @param mixed $sessName
     */
    public function open($savePath, $sessName) {
        $config_redis = Application::getInstance()->config['config']['redis'];
        $config_session = Application::getInstance()->config['config']['session'];
        $this->lifeTime = $config_session['SESSION_OPTIONS']['expire']?$config_session['SESSION_OPTIONS']['expire']:ini_get('session.gc_maxlifetime');
//        var_dump( $this->lifeTime);exit();
        $this->redis = (new CacheRedis($config_redis))->redis;

        return true;
    }

    /**
     * 关闭Session
     * @access public
     */
    public function close() {
     //   var_dump($this->redis);
        return $this->redis->close();
    }

    /**
     * 读取Session
     * @access public
     * @param string $sessID
     */
    public function read($sessID) {
        $data = $this->redis->get($this->prefix.$sessID);
        $data = unserialize($data);
        return $data;
    }

    /**
     * 写入Session
     * @access public
     * @param string $sessID
     * @param String $sessData
     */
    public function write($sessID,$sessData) {
        $expire = time() + $this->lifeTime;
     //   var_dump($sessID);
        $this->redis->set($this->prefix.$sessID,serialize($sessData),$expire);
        return true;
    }

    /**
     * 删除Session
     * @access public
     * @param string $sessID
     */
    public function destroy($sessID) {
        return $this->redis->rm($this->prefix.$sessID);
    }


    /**
     * Session 垃圾回收
     * @access public
     * @param string $sessMaxLifeTime
     */
    public function gc($sessMaxLifeTime) {
        return true;
    }

    /**
     * 打开Session
     * @access public
     */
    public function execute() {
        session_set_save_handler(array(&$this,"open"),
            array(&$this,"close"),
            array(&$this,"read"),
            array(&$this,"write"),
            array(&$this,"destroy"),
            array(&$this,"gc"));
    }
}