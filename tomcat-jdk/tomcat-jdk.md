http://tomcat.apache.org
wget http://apache.fayea.com/tomcat/tomcat-8/v8.0.20/bin/apache-tomcat-8.0.20.tar.gz

https://jdk8.java.net/download.html
http://www.java.net/download/jdk8u60/archive/b06/binaries/jdk-8u60-ea-bin-b06-linux-x64-10_mar_2015.tar.gz


设置环境变量

vi ~/.bashrc
在该文件末尾添加如下配置：

export JAVA_HOME=/data/apps/jdk
export PATH=$PATH:$JAVA_HOME

使环境变量生效：
source ~/.bashrc

启动tomcat
1、
/data/apps/tomcat/bin/startup.sh
2、
ln -s /data/apps/tomcat/bin/startup.sh /usr/bin/startTomcat
startTomcat
停止tomcat
1、
/data/apps/tomcat/bin/shutdown.sh
2、
ln -s /data/apps/tomcat/bin/shutdown.sh /usr/bin/stopTomcat
stopTomcat
查看tomcat版本
/data/apps/tomcat/bin/version.sh

设置虚拟空间
cd /data/apps/tomcat/
vi conf/server.xml 
设置webSite根目录
<Host name="localhost"  appBase="webapps" 
      unpackWARs="true" autoDeploy="true">
#path为虚拟目录,docBase为webSite根目录
<Context path="/" docBase="/data/www" reloadable="true" debug="0"></Context>

web访问：
http://localhost:8080