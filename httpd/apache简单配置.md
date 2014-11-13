apache简单配置：
vi /etc/httpd/conf/httpd.conf

ServerName localhost
DirectoryIndex index.php index.html index.html.var
修改默认目录
DocumentRoot "/var/www"
<Directory "/var/www">

NameVirtualHost *:80去掉注释
复制最后几行改改
vi /etc/httpd/conf.d/a.cuiwei.net.conf
<VirtualHost *:80>
#	ServerAdmin webmaster@dummy-host.example.com
	DocumentRoot /www/a.cuiwei.net
	ServerName a.cuiwei.net
#	ErrorLog logs/dummy-host.example.com-error_log
#	CustomLog logs/dummy-host.example.com-access_log common
</VirtualHost>

================================================================


Apache文件说明：
主配置文件
/etc/httpd/conf/httpd.conf
扩展配置文件
/etc/httpd/conf.d/*.conf
当Apache启动时，会加载/etc/httpd/conf.d/目录中的所有以.conf结尾的文件，做为配置文件来使用，所以管理员可以将配置荐写在.conf中，如果将配置项写入主配置文件，系统升级时，配置项还要重新修改一遍，如果写在扩展配置项，则不存在此问题，同时也可以从繁杂的主配置文件中脱离出来。
扩展模块目录
/usr/lib/httpd/modules/

默认数据目录
/var/www/html
日志目录
/var/log/httpd/
Apache执行脚本
/usr/sbin/apachectl

主配置文件：
ServerRoot "/etc/httpd"
配置项的根目录，配置文件中所有相对路径表示的目录或文件，就在这个目录下
Listen 80
监听端口
修改为192.168.1.22:8080,表示只能通过192.168.1.22:8080访问
Include conf.d/*.conf
扩展配置文件
User apache
Apache子进程所有者
Group apache
Apache子进程所属组
ServerAdmin root@localhost
管理员邮箱
比如当配置文件中ServerSignature选项值为Mail时，访问不存在页面，会显示管理员邮箱链接
 ServerName localhost
服务器的主机名
通常这个值是自动指定的，推荐你显式的指定它以防止启动时出错
UseCanonicalName Off 
设置为"On",Apache会使用ServerName指令的值
设置为 "Off"时,Apache会使用用户端提供的主机名和端口号。 
如果有虚拟主机，必须设置为Off
DocumentRoot "/var/www/html"
网站数据根目录

网站根目录权限设置：
<Directory />
Options Indexes FollowSymLinks		
AllowOverride None
</Directory>

Indexes
如果访问的文件不存在，显示目录文件列表
FollowSymLinks	
在目录下创建a.html软链接，
ln -s /ab/index.html  /var/www/html/a.html
Options Indexes FollowSymLinks时软链接可用
Options Indexes –FollowSymLinks软链接不可用
AllowOverride 
是否允许目录配置文件.htaccess有效ALL有效，None无效

访问权限控制：
Order allow，deny
Allow from all
deny from 192.168.1.106
先匹配allow允许，后匹配deny禁止，虽然192.168.1.106满足Allow查deny是在allow后匹配的，所以192.168.1.106不允许访问

Order deny,allow
deny from all
allow from 192.168.1.106
只允许192.168.1.106访问

默认访问页面：
DirectoryIndex index.html index.html.var
网站默认主页，指定多个时，依次匹配

自定义404错误页：
配置自定义404错误页面
ErrorDocument 404 /404.html
创建404文件 echo ":) File Not Found!" >/var/www/html/404.html
测试：访问一个不存在的页面

日志文件：
Apache服务器运行后会生成两个日志文件，这两个文件是access_log（访问日志）和error_log（错误日志），文件可以在/var/log/httpd/目录下找到。

虚拟主机：
主配置的NameVirtualHost *:80去掉注释
修改/etc/hosts添加内容
127.0.0.1  bbs.cuiwei.net
bbs.cuiwei.net的ip为127.0.0.1
创建Apache扩展配置文件/etc/httpd/conf.d/virtual.conf
<Directory "/var/www/html/bbs">
Options FollowSymlinks
AllowOverride None
</Directory>
<VirtualHost *:80>
ServerAdmin chudaozhe@outlook.com
DocumentRoot /var/www/html/bbs
ServerName bbs.cuiwei.net
ErrorLog logs/bbs.cuiwei.net_error.log
CustomLog logs/bbs.cuiwei.net_access.log
</VirtualHost>