<?php
/**
 * Mongodb Test
 * 
 * Tools:
 * Zend Studio 8.x
 * Eclipse Pulg :Toggle Varpper
 * 
 * @author Wu Bai Qing<wbqyyicx@gmail.com>
 * @version $Id: Mongodb.php 17 2011-09-17 06:04:15Z wbq $ 
 * 来自：http://www.cnblogs.com/wubaiqing/archive/2011/09/17/2179870.html
 */

$mongo_server_name = 'admin';
$mongo_server_pwd  = 'admin';

// 连接Mongo数据库   数据库地址:端口/账号:密码;
$mongo = new Mongo('mongodb://localhost:27017/admin:admin');

// 选择一个数据库和要操作的集(如果没有数据库默认创建)
$collection = $mongo->selectDB('rrs_result')->selectCollection('content');


/*
// 添加
$content = array(
    'title'=>'叶子-吴佰清',
    'author'=>'吴佰清',
    'url'=>'http://www.cnblogs.com/wubaiqing/archive/2011/09/17/2179870.html',
);
$collection->insert($content);
*/

/*
// 查询
$colle = $collection->find(array('title'=>'叶子-吴佰清'));

foreach ($colle as $key => $val)
{
    var_dump($val);
}
*/

/*
// 修改
$where = array('title'=>'叶子-吴佰清');
$set = array('title'=>'叶子');

$collection->update($where,array(
    '$set'=>$set,
));
*/

/*
//删除
$collection->remove(array(
    'title'=>'叶子',
));
*/


// End 2011-09-17 23:39
?>