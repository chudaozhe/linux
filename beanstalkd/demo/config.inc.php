<?php
if (!defined('CWF_PATH')) exit;

return array(
	'default' => array(
		'DB_HOST' => 'localhost',
		'DB_USER' => 'root',
		'DB_PASSWD' => '',
		'DB_NAME' => 'test',
		'DB_PORT' => 3306,
		'DB_CHARSET' => 'utf8'
	),
	'beanstalk' => array(
		//是否长连接
		'persistent' => false,
	    'host' => '192.168.9.102',
	    'port' => 11300,
	    'timeout' => 3
		),
);
