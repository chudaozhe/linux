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
//设置要监听的tube
$beanstalk->watch('test');
//取消对默认tube的监听，可以省略
$beanstalk->ignore('default');
//查看监听的tube列表
// var_dump($beanstalk->listTubesWatched());
//查看test的tube当前的状态
// var_dump($beanstalk->statsTube('test'));
/**
 * //延迟写入
 * put->delayed->ready
 * //立即写入
 * put->ready->reserved(锁定，其他用户不能再操作)
 * reserved->delete(delete之后，job从系统消亡，之后不能再获取)
 * reserved->release(释放，release操作可以重新把该job状态迁移回READY（也可以延迟该状态迁移操作），使其他的consumer可以继续获取和执行该job)
 * reserved->bury(保留，把该job休眠，等到需要的时候，再将休眠的job kick回READY状态，也可以delete BURIED状态的job)->buried
 * 
 * READY - 需要立即处理的任务，当延时 (DELAYED) 任务到期后会自动成为当前任务；
 * DELAYED - 延迟执行的任务, 当消费者处理任务后, 可以用将消息再次放回 DELAYED 队列延迟执行；
 * RESERVED - 已经被消费者获取, 正在执行的任务。Beanstalkd 负责检查任务是否在 TTR(time-to-run) 内完成；
 * BURIED - 保留的任务: 任务不会被执行，也不会消失，除非有人把它 "踢" 回队列；
 * DELETED - 消息被彻底删除。Beanstalkd 不再维持这些消息。
 */
while (true) {
    //获取任务，此为阻塞获取，直到获取有用的任务为止
    //返回格式array('id' => 123, 'body' => 'hello, beanstalk')
    $job = $beanstalk->reserve(); 
    //处理任务
    $result = doJob($job['body']);
    if ($result) {
        //删除任务
        $beanstalk->delete($job['id']);
    } else {
        $stats = $beanstalk -> statsJob($job['id']);
        // file_put_contents('hehe', 'stats:'.date("Y-m-d H:i:s").':'.json_encode($stats)."\n", FILE_APPEND);

        if ($stats['releases'] >=0 && $stats['releases'] <=8) {
            //9次以下延时返回队列
            $timer = array(15,15,30,180,1800,1800,1800,1800,3600);
            // $timer = array(2,3,3,4,5,5,5,6,6);
            $beanstalk->release($job['id'], 0, $timer[$stats['releases']]);
            
        }else{
            //错误次数过多时 bury
            $beanstalk->bury($job['id']);
        }

    }
    
}
// $beanstalk->disconnect();

function doJob($job)
{
    return false;
    $data = json_decode($job, true);
    if (!is_array($data)) exit;

    $db = Mysql::getInstance();

    $add = $db->table('sdkopen')->add($data);
    var_dump($add);
}
