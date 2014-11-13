linux下memcached服务端和php扩展memcache都和php版本无关，下最新的就ok
cd /usr/local/src
wget https://github.com/downloads/libevent/libevent/libevent-2.0.21-stable.tar.gz
tar -xvzf libevent-2.0.21-stable.tar.gz
cd libevent-2.0.21-stable
./configure --prefix=/data/apps/libs
make && make install

wget http://www.memcached.org/files/memcached-1.4.20.tar.gz
tar -xvzf memcached-1.4.20.tar.gz
cd memcached-1.4.20
ls
[mkdir /data/apps/memcached]
./configure --prefix=/data/apps/memcached/ --with-libevent=/data/apps/libs
make && make install

3. 运行memcached
useradd -M -s /sbin/nologin memcache #不创建家目录，不能ssh登录
# /data/apps//memcached/bin/memcached -d -m 128 -l 127.0.0.1 -p 11211 -umemcache
推荐使用启动脚本：
vi /etc/init.d/memcached 详见附1
chmod +x /etc/rc.d/init.d/memcached

service memcached restart
开机启动：
chkconfig --level 345 memcached on

查看运行情况：
ps -ef |grep memcached 
telnet localhost 11211

缺少libevent的错误提示：
checking for libevent directory... configure: error: libevent is required. You can get it from http://www.monkey.org/~provos/libevent/
      If it's already installed, specify its path using --with-libevent=/dir/

安装php扩展：
下载最新版本:
cd /usr/local/src
wget http://pecl.php.net/get/memcache
/data/apps/php/bin/phpize [/usr/bin/phpize]
./configure --with-php-config=/data/apps/php/bin/php-config [/usr/bin/php-config]
make && make install
成功提示：
Build complete.
Don't forget to run 'make test'.

Installing shared extensions:     /data/apps/php/lib/php/extensions/no-debug-non-zts-20121212/ [/usr/lib64/php/modules/]

cd /etc/php.d
cp gd.ini memcache.ini
vi memcache.ini
extension=memcache.so[或者直接加到php.ini]
service httpd restart