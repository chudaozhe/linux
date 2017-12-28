<?php
$conn = oci_connect('scott', 'tiger', '192.168.0.115/ORCL','utf8');

$stid = oci_parse($conn, 'select table_name from user_tables');
//$stid = oci_parse($conn, 'select * from "test1"');
oci_execute($stid);

$data=[];
while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
	$data[]=$row;
}
var_dump($data);