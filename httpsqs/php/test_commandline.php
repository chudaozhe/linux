<?php
include_once("httpsqs_client.php");
$httpsqs = new httpsqs("172.16.1.195", 1218, "123456", "utf-8");

$message = "将文本信息放入一个队列（注意：如果要放入队列的PHP变量是一个数组，需要事先使用序列化、json_encode等函数转换成文本） 
    如果入队列成功，返回布尔值：true  
    如果入队列失败，返回布尔值：false ";

$number = 1;

/* test queue put */
echo "Test Queue PUT, please waitting ...\n";
$start_time = microtime(true);
for ($i=1;$i<=$number;$i++){
    $httpsqs->put("command_line_test", $i.$message);
}
$run_time = microtime(true) - $start_time;
echo "PUT ".$number." messages. Run Time for Queue PUT: $run_time sec, ".$number/$run_time." requests/sec\n";
ob_flush();

/* test queue get */
echo "Test Queue GET, please waitting ...\n";
$start_time = microtime(true);
for ($i=1;$i<=$number;$i++){
    $result = $httpsqs->get("command_line_test");
    echo($result."\n");
}
$run_time = microtime(true) - $start_time;
echo "GET ".$number." messages. Run Time for Queue GET: $run_time sec, ".$number/$run_time." requests/sec\n";
?>