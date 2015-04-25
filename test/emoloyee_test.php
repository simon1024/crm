<?php
require(dirname(__FILE__) . '/header.inc.php');
$curl = new Helper_Curl();
// check exits.
$url = 'http://crm.com/employee/exits?username=zhangyanqing';
$contents = $curl->get($url);
var_dump($contents);
exit;

// check update status
$url = 'http://crm.com/employee/updateStatus';
$array = array('uid'=>11, 'status'=>'9');
$contents = $curl->post($url, $array);
var_dump($contents);
exit;

// check add.
$url = 'http://crm.com/employee/add';
$array = array(
            'name' => '张艳青', 
            'username' => 'zhangyanqing',
            'password'=>'123456',
            'gender' =>'1',
            'position'=>'2',
            'department'=>'3',
            'leader'=>'4',
            'tel'=>'010-88888888',
            'mobile'=>'13401114000',
            'birthday'=>'1980-10-11',
            'joinDate'=>'2013-01-11',
            'role'=>'1',
        );  

$contents = $curl->post($url, $array);
var_dump($contents);

?>
