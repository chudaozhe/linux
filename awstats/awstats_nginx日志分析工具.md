wget http://www.awstats.org/files/awstats-7.4.tar.gz
tar -xvzf awstats-7.4.tar.gz
mv awstats-7.4 /data/apps/awstats
cd /data/apps/awstats/
mkdir data etc
tools/awstats_configure.pl
[详见图片]

#配置文件默认在/etc/awstats,改到/data/apps/awstats/etc下需修改
vi /data/apps/awstats/tools/awstats_buildstaticpages.pl
132     else { @PossibleConfigDir=("$AwstatsDir","$DIR","/data/apps/awstats/etc",
##指定awstats.pl路径
302 elsif (-s "/data/apps/awstats/wwwroot/cgi-bin/awstats.pl") {
303     $Awstats="/data/apps/awstats/wwwroot/cgi-bin/awstats.pl";
304     $AwstatsFound=1;

vi /data/apps/awstats/wwwroot/cgi-bin/awstats.pl
1718     my @PossibleConfigDir = (
1719             ...
1723             "/data/apps/awstats/etc"
1724         );


# vi /etc/awstats/awstats.cuiwei.net.conf
50 LogFile="/var/log/nginx/awstats.cuiwei.net.access.log"

122 # LogFormat=1
122 LogFormat="%host %other %logname %time1 %methodurl %code %bytesd %refererquot %uaquot %otherquot"

203 #DirData="/var/lib/awstats"
203 DirData="/data/apps/awstats/data"

----------显城市------------
将qqip.zip解压到
/data/apps/awstats/wwwroot/cgi-bin/plugins中
在LoadPlugin="hostinfo"的下面增加一行
LoadPlugin="qqhostinfo"


更新数据：
/data/apps/awstats/wwwroot/cgi-bin/awstats.pl -update -config=cuiwei.net 或
# /data/apps/awstats/tools/awstats_buildstaticpages.pl -update  \ 
# -config=cuiwei.net -lang=cn -dir=/data/www/awstats  \
# -awstatsprog=/data/apps/awstats/wwwroot/cgi-bin/awstats.pl
 
上述命令的具体意思如下：
/usr/local/awstats/tools/awstats_buildstaticpages.pl Awstats静态页面生成工具
-update -config=cuiwei.net 更新配置项
-lang=cn 语言为中文
-dir=/data/www/awstats 统计结果输出目录
-awstatsprog=/usr/local/awstats/wwwroot/cgi-bin/awstats.pl Awstats 日志更新程序路径。


穿个漂亮的外衣：
wget http://static.jawstats.com/src/jawstats-0.7beta.tar.gz
cp config.dist.php config.php
vi config.php
[详见jawstats.zip]