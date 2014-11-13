MySQL Community Server (GPL)
http://dev.mysql.com/downloads/mysql/
wget http://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.20.tar.gz
#下载编译工具，也可以yum装
wget http://www.cmake.org/files/v2.8/cmake-2.8.0.tar.gz
./configure --prefix=/data/apps/cmake
make && make install
ln -s /data/apps/cmake/bin/* /usr/bin/

cmake \
-DCMAKE_INSTALL_PREFIX=/data/apps/mysql \
-DMYSQL_DATADIR=/data/apps/mysql/data \
-DSYSCONFDIR=/data/apps/mysql/etc \
-DWITH_MYISAM_STORAGE_ENGINE=1 \
-DWITH_INNOBASE_STORAGE_ENGINE=1 \
-DWITH_MEMORY_STORAGE_ENGINE=1 \
-DWITH_READLINE=1 \
-DMYSQL_UNIX_ADDR=/tmp/mysql.sock \
-DMYSQL_TCP_PORT=3306 \
-DENABLED_LOCAL_INFILE=1 \
-DWITH_PARTITION_STORAGE_ENGINE=1 \
-DEXTRA_CHARSETS=all \
-DDEFAULT_CHARSET=utf8 \
-DDEFAULT_COLLATION=utf8_general_ci

make && make install
cd /data/apps/mysql/
#不创建家目录，不能ssh登录
useradd -M -s /sbin/nologin mysql
id mysql
#初始化数据库
scripts/mysql_install_db --user=mysql
ls /data/apps/mysql/data
vi /data/apps/mysql/my.cnf

#首次以安全模式启动：
bin/mysqld_safe --user=mysql &

#服务端软链：
#使用service[service mysqld start]：
将默认提供的启动脚本 软链到/etc/init.d目录下，这样就可以使用service mysqld start|stop|restart|reload|force-reload|status 操作了，也可以直接/etc/init.d/mysqld start
ln -s /data/apps/mysql/support-files/mysql.server /etc/init.d/mysqld
#加环境变量[mysqld start]：
ln -s /data/apps/mysql/support-files/mysql.server /usr/bin/mysqld

#客户端软链：
#加环境变量[mysql -uroot -p]：
ln -s /data/apps/mysql/bin/mysql /usr/bin/mysql
#默认密码为空

#安全设置引导
./bin/mysql_secure_installation 
