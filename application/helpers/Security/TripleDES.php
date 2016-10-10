<?php
/**
 * Created by JetBrains PhpStorm.
 * User: T171
 * Date: 16-10-10
 * Time: ����10:57
 * To change this template use File | Settings | File Templates.
 */

namespace helpers\Security;

/**
 * Class TripleDES  3DES �ӽ�����, ����java��3DES(DESede)���ܷ�ʽ����
 * Class TripleDES
 * @package helpers\Security
 */
Class TripleDES {
    /**
     * @desc   ����
     *
     * @param  string $input ����
     * @param  string $key   8���ַ���
     * @param  string $iv    8���ַ���
     * @return string
     */
    public function encrypt($input, $key, $iv) {
        $input = $this->__paddingPKCS7($input);
        $td    = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        //ʹ��MCRYPT_3DES�㷨,cbcģʽ
        mcrypt_generic_init($td, $key, $iv);
        //��ʼ����
        $data = mcrypt_generic($td, $input);
        //����
        mcrypt_generic_deinit($td);
        //����
        mcrypt_module_close($td);
        $data = $this->__removeBR(base64_encode($data));
        return $data;
    }
    /**
     * @desc   ����
     *
     * @param  string $encrypted ����
     * @param  string $key       8���ַ���
     * @param  string $iv        8���ַ���
     * @return string
     */
    public function decrypt($encrypted, $key, $iv) {
        $encrypted = base64_decode($encrypted);
        $td        = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        //ʹ��MCRYPT_3DES�㷨,cbcģʽ
        mcrypt_generic_init($td, $key, $iv);
        //��ʼ����
        $decrypted = mdecrypt_generic($td, $encrypted);
        //����
        mcrypt_generic_deinit($td);
        //����
        mcrypt_module_close($td);
        $decrypted = $this->__unPaddingPKCS7($decrypted);
        return $decrypted;
    }
    /**
     * @des    ������룬PKCS7���
     * @param  string $data
     * @return string
     */
    private function __paddingPKCS7($data) {
        $block_size   = mcrypt_get_block_size('tripledes', 'cbc');
        $padding_char = $block_size - (strlen($data) % $block_size);
        $data .= str_repeat(chr($padding_char), $padding_char);
        return $data;
    }
    /**
     * @desc   ɾ������
     * @param  string $text
     * @return bool|string
     */
    private function __unPaddingPKCS7($text) {
        $pad = ord($text{strlen($text) - 1});
        if ( $pad > strlen($text) ) {
            return false;
        }
        // if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
        //     return false;
        // }
        return substr($text, 0, - 1 * $pad);
    }
    /**
     * @desc   ɾ���س��ͻ���
     * @param  string $str
     * @return string
     */
    private function __removeBR($str) {
        $len     = strlen($str);
        $rebuild = "";
        $str     = str_split($str);
        for ( $i = 0; $i < $len; $i ++ )
            if ( $str[$i] != '\n' and $str[$i] != '\r' )
                $rebuild .= $str[$i];
        return $rebuild;
    }
}
