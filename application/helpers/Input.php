<?php
/**
 * User: fish
 * Date: 2016-08-03 23:45
 * Input.php
 */

namespace helpers;

class Input {
    public function trim(&$data){
        $data = array_map('trim',$data);
    }

    public function xss_clean(&$data, array $preserve_key = array()) {
        if (!is_array($data) || empty($data)) {
            return;
        }
        array_walk($data,
            function(&$value, $key) use($preserve_key) {
                if (is_array($value)) {
                    return xss_clean($value, $preserve_key);
                } else {
                    if (in_array($key, $preserve_key) === false) {
                        $value = htmlspecialchars($value, ENT_COMPAT ,'GB2312');
                    }
                }
            });
    }
}