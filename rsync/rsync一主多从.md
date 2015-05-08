[master]
172.16.1.195
[slave]
172.16.1.160
172.16.1.174

yum
---
yum install rsync
yum install inotify-tools

编译
---
https://rsync.samba.org/
#--no-check-certificate不检测证书,只对https起作用
wget --no-check-certificate https://download.samba.org/pub/rsync/rsync-3.1.1.tar.gz
wget --no-check-certificate https://github.com/downloads/rvoicilas/inotify-tools/inotify-tools-3.14.tar.gz

rsync
---

cd rsync*
./configure --prefix=/data/apps/rsync
make && make install
ln -s /data/apps/rsync/bin/* /usr/bin/

inotify-tools
---

./configure --prefix=/data/apps/inotify-tools
make && make install
ln -s /data/apps/inotify-tools/bin/* /usr/bin/


[master] 
cd /data/apps/rsync/
mkdir etc
vi rsyncd.sh
-----------------start-----------------
#!/bin/bash

RSYNC_HOME=/data/apps/rsync/
INOTIFY_HOME=/data/apps/inotify-tools/
#从机ip
HOSTS=(
172.16.1.160
172.16.1.174
)

#要同步的目录
src=/data/www/test/
#定义模块名称
des=web195
#操作用户
user=hehe

${INOTIFY_HOME}bin/inotifywait -mrq --timefmt '%d/%m/%y %H:%M' --format '%T %w%f%e' -e modify,delete,create,attrib @"${INOTIFY_HOME}etc/exclude.txt" $src | while read files
do
${RSYNC_HOME}bin/rsync -vzrtopg --delete --progress --password-file=${RSYNC_HOME}etc/rsync.master.passwd --exclude-from=${RSYNC_HOME}etc/exclude.txt $src $user@${HOSTS[0]}::$des
${RSYNC_HOME}bin/rsync -vzrtopg --delete --progress --password-file=${RSYNC_HOME}etc/rsync.master.passwd --exclude-from=${RSYNC_HOME}etc/exclude.txt $src $user@${HOSTS[1]}::$des
echo "${files} was rsynced" >>${RSYNC_HOME}log/rsync.log 2>&1
done

-----------------end-----------------

[master] 
vi rsync.master.passwd
-----------------start 一行一密码-----------------
hehe123
-----------------end-----------------
chmod 600 rsync.master.passwd

[slave]
-----------------start-----------------
vi rsyncd.conf
uid = root
gid = root
use chroot = no
max connections = 3600
strict modes = yes
pid file = /var/run/rsyncd.pid
lock file = /var/run/rsync.lock
log file = /data/apps/rsync/log/rsyncd.log

#拉取web195模块的的数据
[web195]
path = /data/www/test/
comment = web file
ignore errors
read only = no
#write only = no
#允许拉取172.16.1.195上的数据
hosts allow = 172.16.1.195
#禁止从此ip拉取数据
#hosts deny = *
list = false
auth users = hehe
secrets file = /data/apps/rsync/etc/rsync.passwd
-----------------end-----------------

[slave] vi rsync.passwd
-----------------start 一行一用户名:密码-----------------
hehe:hehe123
-----------------end-----------------
chmod 600 rsync.passwd

开启[master]：
sh rsyncd.sh
开机启动：
echo "/bin/bash /data/apps/rsync/etc/rsyncd.sh &" >> /etc/rc.local
test:在监控目录/data/www/test/里写文件 看其他服务器是否同步

开启[slave]： 
rsync --daemon --config=/data/apps/rsync/etc/rsyncd.conf
echo "rsync --daemon --config=/data/apps/rsync/etc/rsyncd.conf" >> /etc/rc.local

iptables
---

iptables -A INPUT -p tcp -m tcp --dport 873 -j ACCEPT
iptables -A OUTPUT -p tcp -m tcp --dport 873 -j ACCEPT

示例：
#1、下载到本地：
rsync -rv cw@cw.net:/var/www/test /home/wei/Desktop/

#2、将cuiwei.net上的~/Maildir目录【除了里的面.git目录和tmp目录】同步到当前目录里
#--exclude 
rsync -rv --exclude=".git"  --exclude="tmp" cuiwei.net:~/Maildir .
#--exclude-from
rsync -rv --exclude-from=exclude.txt cw.net:~/Maildir .
[root@cw]# cat exclude.txt 
.git 
tmp 
hehe* 

附：
bin/inotifywait 参数
#不监视的文件目录
@"${RSYNC_HOME}etc/exclude.txt"
.git
.swp
hehe

#监视变化的文件
--fromfile=${RSYNC_HOME}etc/fromfile.txt

参考：
http://dl528888.blog.51cto.com/2382721/771533

