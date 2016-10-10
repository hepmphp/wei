<?php

namespace helpers\Security;



/***
 *
 * Class Id �̵�ַ�㷨����id����ת�������ַ����㷨
 * @package helpers\Security
 * @link    http://kvz.io/blog/2009/06/10/create-short-ids-with-php-like-youtube-or-tinyurl/
 */
class Id {
    /**
     * @desc ����˽Կ
     * @var string
     */
    private $__key = 'ytthni';
    /**
     * @desc �׸����ֱ�����4���ϼ��ܽ��Ϊ8λ, β������ƫ�����Ժ��β�����뱣��һ��, Ҳ����˵ƫ������ĩβ����Ϊ0
     * @var  array
     */
    private $__offset = [
        0 => 9597199012520,
        1 => 8356536645430,
        2 => 4939453366740,
        3 => 6114896633240,
        4 => 9568952145630,
        5 => 8998552522210,
        6 => 7833698581110,
        7 => 6959874663250,
        8 => 5676213335990,
        9 => 4596699874650,
    ];
    /**
     * encrypt ����id
     *
     * @access public
     *
     * @param  int $id δ���ܹ�������id
     * @return string   ����id���
     */
    public function encrypt($id) {
        $id = intval($id) + $this->__offset[$this->_getNumberEnd($id)];
        return $this->alphaID($id, false, false, $this->__key);
    }
    /**
     * decrypt ����id
     *
     * @access public
     *
     * @param  string $code �Ѽ��ܹ����ַ���
     * @return int          id����
     */
    public function decrypt($code) {
        $id = $this->alphaID($code, true, false, $this->__key);
        $id = $id - $this->__offset[$this->_getNumberEnd($id)];
        return $id;
    }
    /**
     * ��ȡ���ֵ�ĩλֵ
     *
     * @access public
     *
     * @param  int $number ��Ҫ���ܵ����֣���256
     * @return int            ���ֵ�ĩλֵ����6
     */
    public function _getNumberEnd($number) {
        return substr(strval($number), - 1, 1);
    }
    /**
     * alphaID ת��id�㷨
     *
     * @access public
     *
     * @param mixed   $in       ����ܻ��߽��ܵ�����
     * @param boolean $to_num   �Ƿ�ת��Ϊ���֣�true:�ȽϽ���, false:��ʾ����
     * @param mixed   $pad_up   �Ƿ�ת��Ϊ�������֣���:6 ,���ܽ��һ��Ϊ6λ��false��ʾ�Զ�����
     * @param mixed   $pass_key ��ϼ���˽Կ
     *
     * @return int            ���ֵ�ĩλֵ����6
     */
    public function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null) {
        $index = "abcdefghijklmnopqrstuvwxyz0123456789";
        if ( $pass_key !== null ) {
            // Although this function's purpose is to just make the
            // ID short - and not so much secure,
            // with this patch by Simon Franz (http://blog.snaky.org/)
            // you can optionally supply a password to make it harder
            // to calculate the corresponding numeric ID
            for ( $n = 0; $n < strlen($index); $n ++ ) {
                $i[] = substr($index, $n, 1);
            }
            $passhash = hash('sha256', $pass_key);
            $passhash = (strlen($passhash) < strlen($index))
                ? hash('sha512', $pass_key)
                : $passhash;
            for ( $n = 0; $n < strlen($index); $n ++ ) {
                $p[] = substr($passhash, $n, 1);
            }
            array_multisort($p, SORT_DESC, $i);
            $index = implode($i);
        }
        $base = strlen($index);
        if ( $to_num ) {
            // Digital number  <<--  alphabet letter code
            $in  = strrev($in);
            $out = 0;
            $len = strlen($in) - 1;
            for ( $t = 0; $t <= $len; $t ++ ) {
                $bcpow = bcpow($base, $len - $t);
                $out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
            }
            if ( is_numeric($pad_up) ) {
                $pad_up --;
                if ( $pad_up > 0 ) {
                    $out -= pow($base, $pad_up);
                }
            }
            $out = sprintf('%F', $out);
            $out = substr($out, 0, strpos($out, '.'));
        } else {
            // Digital number  -->>  alphabet letter code
            if ( is_numeric($pad_up) ) {
                $pad_up --;
                if ( $pad_up > 0 ) {
                    $in += pow($base, $pad_up);
                }
            }
            $out = "";
            for ( $t = floor(log($in, $base)); $t >= 0; $t -- ) {
                $bcp = bcpow($base, $t);
                $a   = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in  = $in - ($a * $bcp);
            }
            $out = strrev($out); // reverse
        }
        return $out;
    }
}