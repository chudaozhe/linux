wget http://www.cacti.net/downloads/cacti-0.8.8g.tar.gz
配之前先装好rrdtool,snmp
yum install rrdtool

补丁：
http://docs.cacti.net/manual:087:1_installation.9_pia
新版本貌似用不到

插件：
http://docs.cacti.net/plugins
http://forums.cacti.net/about15067.html

基础插件：
http://docs.cacti.net/plugin:settings
阈值报警
http://docs.cacti.net/_media/plugin:thold-v0.5.0.tgz


监控nginx
yum install perl-libwww-perl

数据来源：http://host/server-status
注意：连接不能有301跳转,不能是https
