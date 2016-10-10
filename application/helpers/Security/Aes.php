<?php

namespace helpers\Security;

/***
 * AES
 * Class AES
 * @package helpers\Security
 */
class AES {
    /**
     * @desc cipher��ֵΪ��Կ���ȿ���Ϊ128��192��256
     * @var  string
     */
    private $__cipher = MCRYPT_RIJNDAEL_128;
    /**
     * @desc ģʽ CBC ECB
     * @var  string
     */
    private $__mode = MCRYPT_MODE_CBC;
    /**
     * @param  string $input ����
     * @param  string $key   16���ַ���
     * @param  string $iv    16���ַ���
     * @return string
     */
    public function encrypt($input, $key, $iv) {
        return base64_encode(mcrypt_encrypt($this->__cipher, $key, $input, $this->__mode, $iv));
    }
    /**
     * @param  string $input ����
     * @param  string $key   16���ַ���
     * @param  string $iv    16���ַ���
     * @return string
     */
    public function decrypt($input, $key, $iv) {
        $input = mcrypt_decrypt($this->__cipher, $key, base64_decode($input), $this->__mode, $iv);
        // @ȥ�����ܺ������ַ���
        return rtrim($input, "\0");
    }
}