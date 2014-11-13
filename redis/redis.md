cd /data/tgz
wget http://download.redis.io/releases/redis-2.8.17.tar.gz
mkdir build
tar -xvzf redis-2.8.17.tar.gz -C /data/tgz/build
cd build/redis-2.8.17/
make PREFIX=/data/apps/redis install
find / -name redis-server

ln -s /data/apps/redis/bin/* /usr/bin/
cp redis.conf /data/apps/redis/conf/
cd /data/apps/redis/conf

vi redis.conf
daemonize yes
timeout 300
#daemonize：是否以后台daemon方式运行pidfile：

redis-server：Redis服务器的daemon启动程序
redis-cli：Redis命令行操作工具.你也可以用telnet根据其纯文本协议来操作
redis-benchmark：Redis性能测试工具，测试Redis在你的系统及你的配置下的读写性能.
redis-stat：Redis状态检测工具，可以检测Redis当前状态参数及延迟状况

开启服务：
redis-server /data/apps/redis/conf/redis.conf
默认端口6379可以指定端口：
/usr/bin/redis-server --port 9999

客户端操作：
[root@cw-centos ~]# redis-cli -p 9999
127.0.0.1:9999> ping
PONG
127.0.0.1:9999> set name cw
OK
127.0.0.1:9999> get name
"cw"

//关闭redis
redis-cli shutdown


----php扩展----
git clone git@github.com:nicolasff/phpredis.git
./configure –with-php-config=/data/apps/php/bin/php-config
make && make install
vi php.ini
extension = redis.so
php-fpm reload

//php中使用
<?php
$redis = new Redis();
$redis->connect('127.0.0.1', '6379');
$redis->set('test', 'abc');
echo  $redis->get('test');