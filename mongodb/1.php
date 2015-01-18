<?php
$mongo = new Mongo("192.168.9.111:27017");
//选择一个库的集合[不存在则自动创建]
$db = $mongo -> cw_blog ->foot;
$doc = array(
	'name' => 'hehe',
	'type' => 'database',
	'count' => 1
);
//插入数据
// $db ->insert($doc);
// 查找所有记录
$result = $db ->find();
foreach ($result as $key => $val)
{
    print_r($val);
}

//列出所有数据库
// $list = $mongo -> listDBs();
// print_r($list);
$mongo ->close();

?>