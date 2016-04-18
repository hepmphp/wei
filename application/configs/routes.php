<?php
$route['fenxiao_jipiao_index_(\d+)_(\d+)'] = 'fenxiao/jipiao/index?page=$1&perpage=$2';
$route['fenxiao_jipiao_test_model']        = 'fenxiao/jipiao/test_model';
$route['fenxiao_jipiao_([a-z]+)']        = 'fenxiao/jipiao/$1';
return $route;
