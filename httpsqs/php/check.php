<?php
// ini_set('display_errors', 'On');
include_once("httpsqs_client.php");
$httpsqs = new httpsqs("172.16.1.195", 1218, "123456", "utf-8");

$check=array(
	array('uid'=>'d001','stats'=>1),
	array('uid'=>'d001','stats'=>0),
	array('uid'=>'d001','stats'=>1),
	array('uid'=>'d001','stats'=>0),
	array('uid'=>'d001','stats'=>1),
	array('uid'=>'d001','stats'=>6)
	);
foreach ($check as $v) {
	$data=urlencode(serialize($v));
	$httpsqs->put($v['uid'], $data);
}
//httpsqs_get 方法
	$data=$httpsqs->get('d001');
	var_dump( unserialize($data) );exit;



















// if ($result) {
// 	$data=$httpsqs->gets('d001');
// 	print_r(unserialize($data));
// 	// print_r(json_decode($data,true));
// }
