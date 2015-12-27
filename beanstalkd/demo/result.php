<?php
define('DEBUG', 0);
header("Content-type:text/html;charset=utf-8");
define('CWF_PATH', 'hehe');
define('APP_PATH', 'D:/phpStudy/WWW/items/beanstalk/');
require_once (APP_PATH . 'lib/functions.php');
C(require_once(APP_PATH . 'config.inc.php'));

ini_set("display_errors", 0);
require_once 'src/Socket/Beanstalk.php';
//实例化beanstalk
$beanstalk = new Socket_Beanstalk( C('beanstalk') );
if (!$beanstalk->connect()) {
    exit(current($beanstalk->errors()));
}
//查看beanstalkd状态
// var_dump($beanstalk->stats());
//查看有多少个tube
// var_dump($beanstalk->listTubes());
$beanstalk->useTube('test');
//设置要监听的tube
$beanstalk->watch('test');
//取消对默认tube的监听，可以省略
$beanstalk->ignore('default');
//查看监听的tube列表
// var_dump($beanstalk->listTubesWatched());
//查看test的tube当前的状态
// var_dump($beanstalk->statsTube('test'));
while (true) {
    //获取任务，此为阻塞获取，直到获取有用的任务为止
    $job = $beanstalk->reserve(); //返回格式array('id' => 123, 'body' => 'hello, beanstalk')
        file_put_contents('hehe', json_encode($job)."\n\n\n", FILE_APPEND);
    //处理任务
    $result = doJob($job['body']);
    if ($result) {
        //删除任务
        $beanstalk->delete($job['id']);
    } else {
        //保留任务
        $beanstalk->bury($job['id']);
    }
    
}
$beanstalk->disconnect();

function doJob($job)
{
    $data = json_decode($job, true);
    if (!is_array($data)) exit;

    $db = Mysql::getInstance();

    $add = $db->table('sdkopen')->add($data);
    var_dump($add);
}
