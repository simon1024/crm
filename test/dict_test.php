<?php
require(dirname(__FILE__) . '/header.inc.php');
$curl = new Helper_Curl();

$url = 'http://crm.com/dict/getList';
$array = array('table'=>'PositionType');
$contents = $curl->post($url, $array);
var_dump($contents);
exit;

// check add.
$url = 'http://crm.com/dict/add';
$array = array('name'=>'General Manager', 'table'=>'PositionType');
$contents = $curl->post($url, $array);
var_dump($contents);
exit;


?>
