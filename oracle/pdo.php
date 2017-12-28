<?php
//$conn = new PDO("oci:dbname=//lochost:1521/test",$db_username,$db_password);
//PDO("oci:dbname=//oracle远程IP:端口号/数据库名",用户名,密码);oci要小写
//若是本机上的数据库，可直接用PDO("oci:dbname=数据库",$db_username,$db_password);
//$dsn_con="oci:host=192.168.0.115;dbname=ORCL;charset=UTF8;prot=1521";
$dsn_con="oci:dbname=//192.168.0.115:1521/ORCL;charset=UTF8";
try{
	$dbh= new PDO($dsn_con,"scott","tiger",array(PDO::ATTR_PERSISTENT => true));
} catch (PDOException $e) {
	print "oci: " . $e->getMessage() . "<br/>";
	die();
}
$sql='select * from "test1"';
//$sql='select table_name from user_tables';
$dbh->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
$rs=$dbh->prepare($sql);
$rs->execute();
$rs->setFetchMode(PDO::FETCH_ASSOC);
$result = $rs->fetchAll();
var_dump($result);