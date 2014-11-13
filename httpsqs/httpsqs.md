#-H 设置硬件资源限制.-S 设置软件资源限制.-n 设置内核可以同时打开的文件描述符的最大值
ulimit -SHn 65535
cd /data/tgz
#安装依赖包
#libevent[memcached也依赖这个]
wget https://github.com/downloads/libevent/libevent/libevent-2.0.21-stable.tar.gz
tar -xvzf libevent-2.0.21-stable.tar.gz

cd libevent-2.0.21-stable
./configure --prefix=/data/apps/libs
make && make install

#tokyocabinet[一种NoSQL,为httpsqs提供持久存储]
wget http://fallabs.com/tokyocabinet/tokyocabinet-1.4.48.tar.gz
tar -xvzf tokyocabinet-1.4.48.tar.gz
cd tokyocabinet-1.4.48
./configure --prefix=/data/apps/tokyocabinet
make && make install
cd ..

#安装httpsqs
wget https://httpsqs.googlecode.com/files/httpsqs-1.7.tar.gz
tar -xvzf httpsqs-1.7.tar.gz
cd httpsqs-1.7
vi Makefile [确认libevent和tokyocabinet的安装路径]

CC=gcc
CFLAGS=-Wl,-rpath,/data/apps/libs/lib/:/data/apps/tokyocabinet/lib/ -L/data/apps/libs/lib/ -levent -L/data/apps/tokyocabinet/lib/ -ltokyocabinet -I/data/apps/libs/include/ -I/data/apps/tokyocabinet/include/ -lz -lbz2 -lrt -lpthread -lm -lc -O2 -g

make && make install
httpsqs -h

killall httpsqs
httpsqs -d -p 1218 -a 123456 -x /data/apps/httpsqs/data

ps aux |grep 1218

开机启动：
echo "httpsqs -d -p 1218 -a 123456 -x /data/apps/httpsqs/data" >>/etc/rc.d/rc.local

httpsqs -h
-l <ip_addr> 监听的IP地址，默认值为 0.0.0.0 
-p <num> 监听的TCP端口（默认值：1218）
-x <path> 数据库目录，目录不存在会自动创建（例如：/data/apps/httpsqs/data）
-t <second> HTTP请求的超时时间（默认值：3）
-s <second> 同步内存缓冲区内容到磁盘的间隔秒数（默认值：5）
-c <num> 内存中缓存的最大非叶子节点数（默认值：1024）
-m <size> 数据库内存缓存大小，单位：MB（默认值：100）
-i <file> 保存进程PID到文件中（默认值：/tmp/httpsqs.pid）
-a <auth> 访问HTTPSQS的验证密码（例如：mypass123）
-d 以守护进程运行
-h 显示这个帮助
请使用命令“killall httpsqs”、“pkill httpsqs”和“kill `cat /tmp/httpsqs.pid`”来停止httpsqs。
注意：请不要使用命令“pkill -9 httpsqs”和“kill -9  httpsqs的进程ID”来结束httpsqs，否则，内存中尚未保存到磁盘的数据将会丢失。

Test:
中国人民：
%E4%B8%AD%E5%9B%BD%E4%BA%BA%E6%B0%91
进队列：
curl "http://172.16.1.195:1218/?name=hehe&opt=put&data=%E4%B8%AD%E5%9B%BD%E4%BA%BA%E6%B0%91&auth=123456"
出队列：
curl "http://172.16.1.195:1218/?charset=utf-8&name=hehe&opt=get&auth=123456"

curl "http://172.16.1.195:1218/?charset=utf-8&name=hehe&opt=status&auth=123456"

curl "http://172.16.1.195:1218/?charset=utf-8&name=hehe&opt=status_json&auth=123456"

根据 http://172.16.1.195:1218/?charset=utf-8&name=hehe&opt=status_json&data=123123&auth=123456中的 putpos的值
查看pos的值[putpos=pos]仅查看不出队
http://172.16.1.195:1218/?charset=utf-8&name=hehe&opt=view&pos=59&data=123123&auth=123456

