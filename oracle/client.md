linux
由于本机是64位linux，所以选择Instant Client for Linux x86-64 
http://www.oracle.com/technetwork/topics/linuxx86-64soft-092277.html
查看oracle服务器端的版本：
 select * from V$version 
结果中有：Oracle Database 11g Enterprise Edition Release 11.2.0.3.0 - 64bit Production
所以oracle客户端也选择11.2.0.3.0版本。
下载如下三个文件：
instantclient-basic-linux.x64-11.2.0.3.0.zip
instantclient-sqlplus-linux.x64-11.2.0.3.0.zip
instantclient-sdk-linux.x64-11.2.0.3.0.zip

解压
mkdir -p /opt/oracle/lib 
mkdir -p /opt/oracle/network/admin
 
解压三个下载文件
unzip instantclient-basic-linux.x64-11.2.0.3.0.zip
unzip instantclient-sqlplus-linux.x64-11.2.0.3.0.zip
unzip instantclient-sdk-linux.x64-11.2.0.3.0.zip
 
解压后内容将在当前目录下的instantclient_11_2下
cd instantclient_11_2
mv sdk  /opt/oracle/sdk
mv *  /opt/oracle/lib

环境变量
vi /etc/profile 
ORACLE_HOME=/opt/oracle
DYLD_LIBRARY_PATH=$ORACLE_HOME/lib
PATH=$JAVA_HOME/bin:$ANT_HOME/bin:$ORACLE_HOME/lib:$PATH
CLASSPATH=.:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar
export JAVA_HOME ANT_HOME PATH CLASSPATH DYLD_LIBRARY_PATH ORACLE_HOME

使生效
source /etc/profile
配置监听器和网络环境
cd  /opt/oracle/network/admin
touch sqlnet.ora tnsnames.ora listener.ora
详见 client/linux

测试
sqlplus sys/oracle@orcl_db as sysdba

可能报so文件找不到，做个软链
ln -s /opt/oracle/lib/*.so* /usr/lib64/

参考
http://hanqunfeng.iteye.com/blog/1955277
