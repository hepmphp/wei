<?php
/**
 * User: fish
 * Date: 2016-08-04 01:02
 * ErrorCode.php
 */

namespace helpers;

class ErrorCode {
    const SUCCESS  = 0;
    const FORM     = -1;//����֤����
    const LOGIC    = -2;//�߼���֤����
    const DB       = -3;//���ݿ���֤����
    const API      = -4;//api�ӿڴ���
}