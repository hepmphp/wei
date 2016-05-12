<?php

namespace helpers\Cache;

class CacheFactory {
    public static function getInstance($type,$config=array())
    {
        if($type=='file'){
            return new File($config);
        }elseif($type=='memcache'){
            return new Memcache($config);
        }elseif($type=='memcached'){
            return new Memcached($config);
        }elseif($type=='redis'){

        }
    }
}