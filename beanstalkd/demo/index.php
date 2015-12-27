<?php
define('DEBUG', 0);
header("Content-type:text/html;charset=utf-8");
define('CWF_PATH', 'hehe');
define('APP_PATH', 'D:/phpStudy/WWW/items/beanstalk/');
require_once (APP_PATH . 'lib/functions.php');
C(require_once(APP_PATH . 'config.inc.php'));

//发送任务
require_once 'src/Socket/Beanstalk.php';
//实例化beanstalk
$beanstalk = new Socket_Beanstalk( C('beanstalk') );
if (!$beanstalk->connect()) {
    exit(current($beanstalk->errors()));
}
//选择使用的tube
$beanstalk->useTube('test');
//往tube中增加数据
$data = array(
		'imei' => str_fun(6),
		'dateline' => time()
	);
$data2 = array(
		'name' => 'bcd',
		'msg' => 'hehe123'
	);

/*
->put(a,b,c,d);
a,任务的优先级
b,不等待直接放到ready队列中
c,处理任务的时间
d,任务内容
 */
$put = $beanstalk->put( 1, 0, 3, json_encode($data));
// $put = $beanstalk->put( 2, 0, 3, json_encode($data2));
if (!$put) {
    exit('commit job fail');
}
$beanstalk->disconnect();



 