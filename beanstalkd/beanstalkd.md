#beanstalkd
##下载安装包
http://kr.github.io/beanstalkd/download.html
https://github.com/kr/beanstalkd/archive/v1.10.tar.gz

vi Makefile
      2 PREFIX=/data/apps/beanstalkd
make && make install

##开启服务
##默认端口11300
beanstalkd -l 192.168.9.102 -b /data/apps/beanstalkd/ &

##启动选项

-b DIR   wal directory[开启binlog，断电后重启会自动恢复任务。]
-f MS    fsync at most once every MS milliseconds (use -f0 for “always fsync”)
-F       never fsync (default)
-l ADDR  listen on address (default is 0.0.0.0)
-p PORT  listen on port (default is 11300)
-u USER  become user and group
-z BYTES set the maximum job size in bytes (default is 65535)
-s BYTES set the size of each wal file (default is 10485760)
(will be rounded up to a multiple of 512 bytes)
-c       compact the binlog (default)
-n       do not compact the binlog
-v       show version information
-V       increase verbosity
-h       show this help


#BStools 监控工具
##下载安装包
https://github.com/jimbojsb/bstools/archive/v0.5.tar.gz
cd bin/
php bs.php stats --host="192.168.9.102"

#Chrome 插件
https://chrome.google.com/webstore/detail/beanstalkd-dashboard/dakkekjnlffnecpmdiamebeooimjnipm

#php客户端
https://github.com/davidpersson/beanstalk
https://github.com/davidpersson/beanstalk/archive/v1.0.0.tar.gz

#参考：
http://blog.chedushi.com/archives/8026
http://blog.csdn.net/black_ox/article/details/24792489
https://segmentfault.com/a/1190000002784775
