<?php
namespace models\Jipiao;
use base\Model;

class Passenger extends Model{
    public static $table = 'cgfx_jipiao_passenger';
    public static function hello(){
        echo "HELLO";
    }
}