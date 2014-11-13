<?php
include_once("httpsqs_client.php");
$httpsqs = new httpsqs("172.16.1.195", 1218, "123456", "utf-8");
$result = $httpsqs->put("hehe", urlencode("text_message1"));
echo "###1.put result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->get("hehe");
echo "###2.get result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->put("hehe", urlencode("text_message2"));
echo "###3.put result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->gets("hehe");
echo "###4.gets result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->status("hehe");
echo "###5.status result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->status_json("hehe");
echo "###6.status_json result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->view("hehe", 1);
echo "###7.view result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->reset("hehe");
echo "###8.reset result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->maxqueue("hehe", 5000000);
echo "###9.maxqueue result:\r\n";
var_dump($result);
echo "\r\n\r\n";

$result = $httpsqs->synctime(10);
echo "###10.synctime result:\r\n";
var_dump($result);
echo "\r\n\r\n";
?>