wget http://sourceforge.net/projects/net-snmp/files/net-snmp/5.7.3/net-snmp-5.7.3.tar.gz

tar -xvzf net-snmp-5.7.3.tar.gz
cd net-snmp-5.7.3
./configure --prefix=/data/apps/snmp --with-mib-modules=ucd-snmp/diskio --enable-mfd-rewrites --with-default-snmp-version="3" --with-sys-location="China" --with-sys-contact="chudaozhe@outlook.com" --with-logfile="/data/apps/snmp/log/snmpd.log" --with-persistent-directory="/data/apps/snmp/net-snmp"

--with-mib-modules=ucd-snmp/diskio	#可以让服务器支持磁盘I/O监控
--enable-mfd-rewrites	#允许用新的MFD重写可用的mid模块
--with-default-snmp-version	#默认的SNMP版本(通常有三种形式：1,2[for SNMPv2c],3)
--with-sys-location	#设备位置
--with-sys-contact	#设备联系人
--with-logfile	#日志文件位置
--with-persistent-directory	#数据存储目录
make && make install

#复制示例配置
cp EXAMPLE.conf /data/apps/snmp/share/snmp/snmpd.conf

ls /data/apps/snmp

v2c
---

添加只读用户
vi /data/apps/snmp/share/snmp/snmpd.conf
#只读		密码		ip
rocommunity jiankongbao 60.195.252.107
rocommunity jiankongbao 60.195.252.110

注意：添加用户时，请确保snmp服务没有运行，否则无法添加。 

v3
---
vi /data/apps/snmp/share/snmp/snmpd.conf
#只读帐号 用户名 需验证
rouser cw auth

vi /data/apps/snmp/net-snmp/snmpd.conf
#创建用户 用户名 加密方式 密码
createUser cw MD5 cw888
注意：snmpd启动后，出于安全考虑，以上这行配置会被snmpd自动转换为密文的形式记录在其它文件中，重新启动snmpd是不需要再次添加这些配置的，除非你希望创建新的用户。 



启动
/data/apps/snmp/sbin/snmpd
关闭
killall -9 snmpd

测试v3
snmpwalk -v 3 -u cw -l auth -a MD5 -A cw888 localhost
snmpget -v 3 -u cw -l authNoPriv -a MD5 -A cw888 localhost sysUpTime.0
测试v2c
snmpwalk -v 2c -c public localhost
测试v1
snmpwalk -v 1 -c public localhost


设置防火墙
iptables -A INPUT -i eth0 -p udp -s 60.195.252.107 --dport 161 -j ACCEPT
iptables -A INPUT -i eth0 -p udp -s 60.195.252.110 --dport 161 -j ACCEPT


http://wiki.jiankongbao.com/doku.php/%E6%96%87%E6%A1%A3:%E5%AE%89%E5%85%A8%E6%8C%87%E5%BC%95#linux_snmp

/var/log/snmpd.log
/var/net-snmp