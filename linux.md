1, selinux
vi /etc/sysconfig/selinux
# SELINUX=enforcing
SELINUX=disabled

2, 修改时区
2.1 date #查看时间是否正确，不正确则执行以下步骤
2.2 rm -rf /etc/localtime
2.3 ln -s /usr/share/zoneinfo/Asia/Shanghai /etc/localtime
2.4 设置时区
	tzselect
2.5 同步时间
	ntpdate cn.pool.ntp.org

2.6 date

3, 把主分区改为/data
3.1 mkdir /data
3.2 vi /etc/fstab
/dev/mapper/VolGroup-lv_home /data                   ext4    defaults        1 2
3.3 mount -a
3.4 init 6

4, epel源
rpm -Uvh http://dl.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm
rpm --import /etc/pki/rpm-gpg/RPM-GPG-KEY-EPEL-6

5, 开启RSA验证
见文档 git/git编译安装.md

6, scp
yum install openssh-clients


7, 检查是否安装过 httpd,php,mysql,有则卸载
[root@localhost ~]# whereis httpd
httpd:
[root@localhost ~]# whereis php
php:
[root@localhost ~]# whereis mysql
mysql: /usr/lib64/mysql /usr/share/mysql

yum remove mysql*

8, tmux(防止意外断开连接，操作中断)
见文档 tmux/tmux.md

9, 设置防火墙规则
sh iptables.sh #建议在tmux下面执行此操作

10, crontab 
yum install vixie-cron