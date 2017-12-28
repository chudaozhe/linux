windows
1
下载instantclient_11_2（我的php是32位，这里就下32位）
http://download.oracle.com/otn/nt/instantclient/11204/instantclient-basic-nt-11.2.0.4.0.zip
下载完，解压，然后把目录（E:\oracle\instantclient_11_2）加入环境变量，注销一下才生效
不用配 network\admin\tnsnames.ora
2
选择合适版本
http://pecl.php.net/package/oci8
php7.1
http://windows.php.net/downloads/pecl/releases/oci8/2.1.8/php_oci8-2.1.8-7.1-nts-vc14-x86.zip
下载下来，只用到里面的一个文件
php_oci8_11g.dll
放到php 扩展目录, 然后
vi php.ini
extension=php_pdo_oci.dll
extension=php_oci8_11g.dll

