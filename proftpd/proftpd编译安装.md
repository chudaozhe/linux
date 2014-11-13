wget ftp://ftp.proftpd.org/distrib/source/proftpd-1.3.5.tar.gz
tar -xvzf proftpd-1.3.5.tar.gz
cd proftpd-1.3.5
ls
./configure --prefix=/data/apps/proftpd --sysconfdir=/etc[也可以不指定配置文件目录]
make && make install

groupadd ftpwei　            ← 建ftp用户组
useradd cui -g ftpwei -d /data/www -s /sbin/nologin    ← 建用户，所属目录，禁止ssh登录
chown -R cui:ftpwei /data/www   ← 设置用户的目录权限

cd /data/apps/proftpd/
编辑配置文件：
vi /data/apps/proftpd/etc/proftpd.conf 详见附1
创建启动脚本：
vi /etc/rc.d/init.d/proftpd 详见附2

chmod 755 /etc/rc.d/init.d/proftpd

启动：
service proftpd start
设置开机启动：
chkconfig --level 345 proftpd on

问题1：:
[root@cw-centos ~]# /data/apps/proftpd/sbin/proftpd [service proftpd start]
ftp proftpd[19421]: warning: unable to determine IP address of 'ftp'
ftp proftpd[19421]: error: no valid servers configured
ftp proftpd[19421]: Fatal: error processing configuration file '/data/apps/proftpd/etc/proftpd.conf'
解决：需要指定服务器的IP
修改配置文件添加如下新代码，重启服务即可
DefaultAddress                  192.168.9.106