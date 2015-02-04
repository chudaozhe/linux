<?php
//将./demo目录下的所有.php文件打包为./my.phar
$phar = new Phar('my.phar');
$phar->buildFromDirectory(dirname(__FILE__) . '/demo', '/\.php$/');
$phar->compressFiles(Phar::GZ);
$phar->stopBuffering();