#查找是否已经安装
rpm -qa | grep Mysql

#下载rpm包
wget http://mirrors.sohu.com/mysql/MySQL-5.6/MySQL-server-5.6.17-1.rhel5.x86_64.rpm
wget http://mirrors.sohu.com/mysql/MySQL-5.6/MySQL-client-5.6.17-1.rhel5.x86_64.rpm

#安装
rpm -ivh MySQL-server-5.6.17-1.rhel5.x86_64.rpm
rpm -ivh MySQL-client-5.6.17-1.rhel5.x86_64.rpm

cp /usr/share/mysql/my-default.cnf /etc/my.cnf


#卸载
rpm -e MySQL-server-5.6.17-1.rhel5.x86_64
rpm -e MySQL-client-5.6.17-1.rhel5.x86_64
rm -f /etc/my.cnf
rm -rf /var/lib/mysql


