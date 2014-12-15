wget http://sourceforge.net/projects/pcre/files/pcre/8.36/pcre-8.36.tar.gz
tar -xvzf pcre-8.36.tar.gz
cd pcre-8.36
./configure --prefix=/data/apps/libs
make && make install

wget http://nginx.org/download/nginx-1.7.8.tar.gz
tar -xvzf nginx-1.7.8.tar.gz 
cd nginx-1.7.8

useradd -M -s /sbin/nologin www #不创建家目录，不能ssh登录
./configure --user=www --group=www --prefix=/data/apps/nginx --conf-path=/data/apps/nginx/conf/nginx.conf --pid-path=/data/apps/nginx/logs/nginx.pid --with-http_stub_status_module --with-http_ssl_module --with-pcre=/data/tgz/libs/pcre-8.36 --with-http_realip_module --with-http_image_filter_module
make && make install
启动nginx :
ln -s /data/apps/nginx/sbin/nginx /usr/bin/nginxd
nginxd -s reload
结束进程
kill   -HUP   是用来向指定进程发送一个HUP信号，许多程序在收到HUP信号时，会重新读取配置文件   
这也就是为什么修改了配置后通常要用kill   -HUP的原因了
kill `cat /data/apps/nginx/logs/nginx.pid` 
1. kill -HUP `cat /data/apps/nginx/logs/nginx.pid`
2. nginxd -s reload 
推荐使用启动脚本：
vi /etc/init.d/nginx 详见附1
chmod +x /etc/rc.d/init.d/nginx
开机启动：
chkconfig --level 345 nginx on

问题1：
[root@cw conf]# nginxd -s reload 
nginx: [error] open() "/data/apps/nginx/logs/nginx.pid" failed (2: No such file or directory) 
[root@cw conf]# 
[root@cw conf]# /data/apps/nginx/sbin/nginx -c /data/apps/nginx/conf/nginx.conf 
使用nginx -c的参数指定nginx.conf文件的位置