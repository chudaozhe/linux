wget http://sourceforge.net/projects/net-snmp/files/net-snmp/5.7.3/net-snmp-5.7.3.tar.gz

tar -xvzf net-snmp-5.7.3.tar.gz
cd net-snmp-5.7.3
./configure --prefix=/data/apps/snmp --with-mib-modules=ucd-snmp/diskio
make && make install

ls /data/apps/snmp

v2c

添加只读用户
vi /data/apps/snmp/share/snmp/snmpd.conf
#只读		密码		ip
rocommunity jiankongbao 60.195.252.107
rocommunity jiankongbao 60.195.252.110

注意：添加用户时，请确保snmp服务没有运行，否则无法添加。 

启动
/data/apps/snmp/sbin/snmpd
关闭
killall -9 snmpd

设置防火墙
iptables -A INPUT -i eth0 -p udp -s 60.195.252.107 --dport 161 -j ACCEPT
iptables -A INPUT -i eth0 -p udp -s 60.195.252.110 --dport 161 -j ACCEPT


http://wiki.jiankongbao.com/doku.php/%E6%96%87%E6%A1%A3:%E5%AE%89%E5%85%A8%E6%8C%87%E5%BC%95#linux_snmp

/var/log/snmpd.log
/var/net-snmp