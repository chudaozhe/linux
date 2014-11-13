Sphinx 分区查询 分区合并 增量索引（配置多个数据源）索引合并

yum -y install make gcc gcc-c++ libtool autoconf automake imake mysql-devel libxml2-devel expat-devel

wget http://sphinxsearch.com/files/sphinx-2.1.1-beta.tar.gz
mkdir /opt/sphinx
./configure --prefix=/opt/sphinx/
# make clean 如果make错误可以执行一下
make && make install

cd /opt/sphinx/etc
#导入示例表，默认使用test库
mysql -uroot -p< example.sql 
cp sphinx.conf.dist sphinx.conf
vi sphinx.conf
#默认数据源[source src1]
     23         # some straightforward parameters for SQL source types
     24         sql_host                = localhost
     25         sql_user                = root
     26         sql_pass                = 
     27         sql_db                  = test
     28         sql_port                = 3306  # optional, default is 3306

     79          sql_query_pre          = SET NAMES utf8

     327         source                  = src1

cd ../bin
#生成索引
./indexer --all
#搜索string'this'
./search this

----缺点----
mysql> status;
Server characterset:    utf8
Db     characterset:    utf8
Client characterset:    utf8
Conn.  characterset:    utf8

[root@cw-centos bin]# locale
LANG=en_US.UTF-8
LC_CTYPE="en_US.UTF-8"
LC_NUMERIC="en_US.UTF-8"
LC_TIME="en_US.UTF-8"
LC_COLLATE="en_US.UTF-8"
LC_MONETARY="en_US.UTF-8"
LC_MESSAGES="en_US.UTF-8"
LC_PAPER="en_US.UTF-8"
LC_NAME="en_US.UTF-8"
LC_ADDRESS="en_US.UTF-8"
LC_TELEPHONE="en_US.UTF-8"
LC_MEASUREMENT="en_US.UTF-8"
LC_IDENTIFICATION="en_US.UTF-8"
LC_ALL=


---------------------上面是原版sphinx不支持中文-------------

---------------------下面coreseek是修改版sphinx加入了mmseg中文词库支持中文-------------
wget http://www.coreseek.cn/uploads/csft/4.0/coreseek-4.1-beta.tar.gz
#安装mmseg分词工具【帮着分词】
mkdir /opt/mmseg
./bootstrap #检测安装环境，输出的warning信息可以忽略，如果出现error则需要解决
./configure --prefix=/opt/mmseg/
make && make install
#使用mmseg把t1.txt里的中文文章分成词语 -d 指定配置文件
./mmseg -d /opt/mmseg/etc/ /usr/local/src/coreseek-4.1-beta/mmseg-3.2.14/src/t1.txt
或./mmseg -d ../etc/ test.txt

#安装coreseek[修改版sphinx]【帮着创索引】
mkdir /opt/coreseek
cd /usr/local/src/coreseek-4.1-beta/csft-4.1/
sh buildconf.sh #检测安装环境，输出的warning信息可以忽略，如果出现error则需要解决

./configure --prefix=/opt/coreseek --without-unixodbc --with-mmseg --with-mmseg-includes=/opt/mmseg/include/mmseg/ --with-mmseg-libs=/opt/mmseg/lib/ --with-mysql
make && make install

cd /opt/coreseek/etc
cp sphinx.conf.dist csft.conf 
vi csft.conf
#建库fenci{news(id主建,title,conftent)}


     23         # some straightforward parameters for SQL source types
     24         sql_host                = localhost
     25         sql_user                = root
     26         sql_pass                = 
     27         sql_db                  = fenci
     28         sql_port                = 3306  # optional, default is 3306
#发sql之前设置字符集
     79          sql_query_pre          = SET NAMES utf8
#关闭查询缓存
     80          sql_query_pre          = SET SESSION query_cache_type=OFF
#SELECT 后第一个必须是主键
     88         sql_query               =SELECT id,title,content FROM news

    241         sql_query_info          = SELECT * FROM news WHERE id=$id


    388         # charset encoding type
    389         # optional, default is 'sbcs'
    390         # known types are 'sbcs' (Single Byte CharSet) and 'utf-8'
    391         charset_type            = zh_cn.utf-8
    392         charset_dictpath        = /opt/mmseg/etc/

生成索引：
cd ../bin
生成索引 默认加载/etc/csft.conf ,手动指定 -c /etc/csft.conf
 ./indexer --all
 ./search china
或./search -c /etc/csft_mysql.conf 中国

 开启服务让php连接
 ./searchd -c /etc/csft_mysql.conf --console

 开启服务错误解决：
1、WARNING: compat_sphinxql_magics=1 is deprecated; please update your application and config：compat_sphinxql_magics设置在新版中可能(网上的资料中有提到是rt索引的原因)已经被弃用了，但是程序中貌似有个默认值，需要手动在自己的配置文件中将其设置为0。 
此配置参数要加在：searchd
{
compat_sphinxql_magics = 0
}


----php sphinx扩展安装：--------------------------------------------
在php手册里找sphinx扩展安装方法：http://pecl.php.net/get/sphinx
wget http://pecl.php.net/get/sphinx
mv sphinx sphinx.tar.gz
mv sphinx-1.3.2/ sphinx-php
cd sphinx-php
	装php扩展必须用到phpize
	yum install php-devel

必须先：
cd /usr/local/src/coreseek-4.1-beta/testpack/api/libsphinxclient
./configure
make && make install

然后：
phpize
./configure --with-php-config=/usr/bin/php-config --with-sphinx
make && make install

cd /etc/php.d
cp gd.ini sphinx.ini
vi sphinx.ini
sphinx.so
service httpd restart


---------错误------------

search 执行没有问题，用到api时候就会报如下错误Fatal error: Cannot redeclare class SphinxClient in ../sphinxapi.php on line 387
原因：把sphinx的php 扩展卸载就ok了，加上扩展的话就不用引用程序中API了，可以直接使用
