<?php
include_once("httpsqs_client.php");
$httpsqs = new httpsqs("172.16.1.195", 1218, "123456", "utf-8");
$data=array(
	array('name'=>'李时珍','content'=>'本草纲目'),
	array('name'=>'华佗','content'=>'麻沸散')
);
$data=urlencode(serialize($data));
// $data=urlencode(json_encode($data));
$result = $httpsqs->put("hehe", $data);
$result = $httpsqs->put("dede", $data);
if ($result) {
	$data=$httpsqs->get("hehe");
	print_r(unserialize($data));
	// print_r(json_decode($data,true));
}

if ($data=$httpsqs->get("dede")) {
	if ($data<>'HTTPSQS_GET_END') {
		print_r(unserialize($data));
	}
}else{
	echo "没有数据";
}

