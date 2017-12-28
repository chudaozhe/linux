1调整/dev/shm的大小
2iptables:
vi /etc/sysconfig/iptables
-A INPUT -p tcp -m tcp --dport 1521 -j ACCEPT
-A INPUT -p tcp -m tcp --dport 1158 -j ACCEPT
3修改HOSTNAME
vi /etc/hosts
vi /etc/sysconfig/network
NETWORKING=yes
HOSTNAME=centos-oracle
改完，重启一下

依赖包
cd /etc/yum.repos.d
wget http://yum.oracle.com/public-yum-ol6.repo
vi public-yum-ol6.repo
[ol6_latest]
name=Oracle Linux $releasever Latest ($basearch)
baseurl=http://yum.oracle.com/repo/OracleLinux/OL6/latest/$basearch/
gpgkey=http://yum.oracle.com/RPM-GPG-KEY-oracle-ol6
gpgcheck=1
enabled=1

[ol6_UEK_latest]
name=Latest Unbreakable Enterprise Kernel for Oracle Linux $releasever ($basearch)
baseurl=http://yum.oracle.com/repo/OracleLinux/OL6/UEK/latest/$basearch/
gpgkey=http://yum.oracle.com/RPM-GPG-KEY-oracle-ol6
gpgcheck=1
enabled=1

yum install oracle-rdbms-server-11gR2-preinstall

给oracle用户设个密码
passwd oracle
切换到oracle用户，执行一下操作
su oracle
准备
mkdir -p /home/oracle/oradata /home/oracle/fast_recovery_area /home/oracle/etc/ /home/oracle/app /home/oracle/app/oracle/product/11.2.0/dbhome_1 /home/oracle/inventory

http://download.oracle.com/otn/linux/oracle11g/R2/linux.x64_11gR2_database_1of2.zip
http://download.oracle.com/otn/linux/oracle11g/R2/linux.x64_11gR2_database_2of2.zip

解压到/home/oracle/database
提取配置文件
cp /home/oracle/database/response/* /home/oracle/etc/


添加环境变量
vi ~/.bashrc
umask 022
export ORACLE_BASE=/home/oracle/app
export ORACLE_HOME=$ORACLE_BASE/oracle/product/11.2.0/dbhome_1
export ORACLE_SID=orcl
export PATH=$PATH:$HOME/bin:$ORACLE_HOME/bin
export LD_LIBRARY_PATH=$ORACLE_HOME/lib:/usr/lib


准备安装
vi /home/oracle/etc/db_install.rsp
oracle.install.option=INSTALL_DB_SWONLY // 安装类型
ORACLE_HOSTNAME=centos-oracle // 主机名称（hostname查询）
UNIX_GROUP_NAME=oinstall // 安装组
INVENTORY_LOCATION=/home/oracle/inventory //INVENTORY目录（不填就是默认值）
SELECTED_LANGUAGES=en,zh_CN // 选择语言
ORACLE_HOME=/home/oracle/app/oracle/product/11.2.0/dbhome_1 // oracle_home
ORACLE_BASE==/home/oracle/app // oracle_base
oracle.install.db.InstallEdition=EE // oracle版本
oracle.install.db.isCustomInstall=false //自定义安装，否，使用默认组件
oracle.install.db.DBA_GROUP=dba // dba用户组
oracle.install.db.OPER_GROUP=oinstall // oper用户组
oracle.install.db.config.starterdb.type=GENERAL_PURPOSE //数据库类型
oracle.install.db.config.starterdb.globalDBName=orcl //globalDBName
oracle.install.db.config.starterdb.SID=orcl //SID
oracle.install.db.config.starterdb.memoryLimit=81920 //自动管理内存的内存(M)
oracle.install.db.config.starterdb.password.ALL=oracle //设定所有数据库用户使用同一个密码
SECURITY_UPDATES_VIA_MYORACLESUPPORT=false
DECLINE_SECURITY_UPDATES=true

开始安装
cd database
chmod +x runInstaller install/.oui install/*.sh install/lsnodes  install/unzip
./runInstaller -ignorePrereq -silent -responseFile /home/oracle/etc/db_install.rsp
su root
/home/oracle/inventory/orainstRoot.sh
/home/oracle/app/oracle/product/11.2.0/dbhome_1/root.sh
su oracle
实例基本参数
cd /home/oracle/app/oracle/product/11.2.0/dbhome_1/dbs
cp init.ora  initorcl.ora (init{SID}.ora)
vi initorcl.ora
audit_file_dest='/home/oracle/app/admin/orcl/adump'
db_recovery_file_dest='/home/oracle/app/flash_recovery_area'
diagnostic_dest='/home/oracle/app'

建库
vi /home/oracle/etc/dbca.rsp
GDBNAME = "orcl"
SID = "orcl"
SYSPASSWORD = "oracle"
SYSTEMPASSWORD = "oracle"
SYSMANPASSWORD = "oracle"
DBSNMPPASSWORD = "oracle"
DATAFILEDESTINATION =/home/oracle/oradata
RECOVERYAREADESTINATION=/home/oracle/fast_recovery_area
CHARACTERSET = "AL32UTF8"
TOTALMEMORY = "1638"

执行建库
dbca -silent -responseFile /home/oracle/etc/dbca.rsp
查看oracle实例进程
ps -ef | grep ora_ | grep -v grep
启动监听
lsnrctl start
监听状态
lsnrctl status


登录sqlplus
sqlplus / as sysdba (正常免密码，有密码提示就错了)
startup
查看数据库版本信息
select * from v$version;
查看服务名(Oracle的实例名)
select instance_name from v$instance;
表结构：
desc "SCOTT"."test1";
表数据：
SELECT * FROM "SCOTT"."test1";

激活scott用户
alter user scott account unlock;
alter user scott identified by tiger;
查看所有表：
select table_name from dba_tables where owner='SCOTT';

PL/SQL
select * from "test1" where "id"=2;

退出sql,安装企业管理器:
emca -config dbcontrol db
Database SID: orcl
Listener port number: 1521
Listener ORACLE_HOME [ /home/oracle/app/oracle/product/11.2.0/dbhome_1 ]: 回车
Password for SYS user: oracle
Password for DBSNMP user: oracle
Password for SYSMAN user: oracle
Email address for notifications (optional): 11@qq.com
Outgoing Mail (SMTP) server for notifications (optional): 回车

然后
https://localhost:1158/em/
用户名 sys
口令 oracle
连接身份 sysdba

启动脚本
cd /home/oracle/app/oracle/product/11.2.0/dbhome_1
vi bin/dbstart
#ORACLE_HOME_LISTNER=$1
ORACLE_HOME_LISTNER=$ORACLE_HOME
vi bin/dbshut
#ORACLE_HOME_LISTNER=$1
ORACLE_HOME_LISTNER=$ORACLE_HOME
vi /etc/oratab
orcl:/home/oracle/app/oracle/product/11.2.0/dbhome_1:Y
vi /etc/init.d/oracle
chmod +x /etc/init.d/oracle
详见oracle
chmod +x /etc/rc.d/init.d/oracle
开机启动：
chkconfig --level 345 oracle on
取消开机启动
chkconfig --level 345 oracle off
其他
一.启动
1.#su oracle              切换到oracle用户且切换到它的环境
2.$lsnrctl status           查看监听及数据库状态
3.$lsnrctl start            启动监听
$emctl start dbconsole 启动企业管理器
4.$sqlplus / as sysdba       以DBA身份进入sqlplus
5.SQL>startup                启动db
二.停止
1.#su - oracle              切换到oracle用户且切换到它的环境
2.$lsnrctl stop             停止监听
$emctl stop dbconsole 关闭企业管理器
3.$sqlplus / as sysdba      以DBA身份进入sqlplus
4.SQL>SHUTDOWN IMMEDIATE    关闭db

参考：
http://blog.itpub.net/29510932/viewspace-1135313/
http://blog.csdn.net/Kenny1993/article/details/75038670
解决依赖包
http://www.oracle.com/technetwork/cn/articles/servers-storage-admin/ginnydbinstallonlinux-488779.html
使用脚本自启动oracle
http://blog.csdn.net/u010884123/article/details/55657674
调整/dev/shm的大小
http://blog.51cto.com/2358205/1001537
调整/dev/shm的大小。
修改/etc/fstab，重新mount /dev/shm，然后就可以启动数据库了。

（1）查看/dev/shm 大小
df -k /dev/shm
Filesystem 1K-blocks Used Available Use% Mounted on
tmpfs 4089416 0 4089416 0% /dev/shm
（2）调整/dev/shm大小
vi /etc/fstab
#tmpfs /dev/shm tmpfs defaults 0 0
tmpfs /dev/shm tmpfs defaults,size=10240M 0 0
（3）重新加载
umount /dev/shm
mount /dev/shm
df -k /dev/shm
（4）登陆测试
sqlplus / as sysdba
PL/SQL如何远程连接ORACLE
https://www.cnblogs.com/milantgh/p/4286716.html
企业管理器
http://www.jb51.net/article/53838.htm
在linux上安装完oracle数据库后，如何修改ORACLE_HOSTNAME
https://www.2cto.com/database/201404/291378.html


