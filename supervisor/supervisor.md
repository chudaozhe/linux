Linux后台进程管理利器：supervisor
Linux的后台进程运行有好几种方法，例如nohup，screen等，但是，如果是一个服务程序，要可靠地在后台运行，我们就需要把它做成daemon，最好还能监控进程状态，在意外结束时能自动重启。
supervisor就是用Python开发的一套通用的进程管理程序，能将一个普通的命令行进程变为后台daemon，并监控进程状态，异常退出时能自动重启。

安装

yum install supervisor

创建配置文件：

echo_supervisord_conf > /etc/supervisord.conf

开启supervisor服务

[root@fedora ~]# supervisord

打开命令行
[root@fedora ~]# supervisorctl
supervisor> help
supervisor> status
supervisor> exit

web管理
vi /etc/supervisord.conf
[inet_http_server]
;允许哪个ip访问
port=192.168.9.111:9001
;username=user
;password=123


如果修改了配置文件 重载使生效
supervisorctl reload

示例

vi /etc/supervisord.d/nginx.ini
[program:nginx] #定义监控系统的名称
command=ngixn ＃重启进程的命令
autorstart=true ＃是否自动启动

＃默认这些就够了，系统还支持
process_name=%(program_name)s ＃进程名称，默认是程序名称
numprocs=1 ＃进程数量
directory=/tmp ＃路径
umask=022 ＃掩码
priority=999 ＃优先级，越大被开起的越早
autorestart=true ＃自动重启
startsecs=10 ＃启动等待时间（秒）
startretries=3 ＃启动重试次数
stopsignal=TERM ＃关闭信号
stopwaitsecs=10 ＃关闭前等待时间
user=chrism ＃监控用户权限
redirect_stderr=false ＃重定向报错输出
stdout_logfile=/a/path ＃输入重定向为日志
stdout_logfile_maxbytes=1MB ＃日志大小
stdout_logfile_backups=10 ＃日志备份
stdout_capture_maxbytes=1MB 
stderr_logfile=/a/path
stderr_logfile_maxbytes=1MB
stderr_logfile_backups=10
stderr_capture_maxbytes=1MB
environment=A=1,B=2 ＃预定义环境变量
serverurl=AUTO ＃系统URL

参考

http://www.nowamagic.net/academy/detail/1332312


 