<?php
$cluster   = Cassandra::cluster()                 // connects to localhost by default
->withContactPoints('192.168.0.88')
	->withCredentials('cw', '123456')       //用户名，密码
	->build();
$keyspace  = 'test111';
$session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace
$statement = new Cassandra\SimpleStatement(       // also supports prepared and batch statements
	'SELECT * FROM user'
);
$future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
$result    = $future->get();                      // wait for the result, with an optional timeout
foreach ($result as $row) {                       // results and rows implement Iterator, Countable and ArrayAccess
	print_r($row);
}