系统fedroa 20
简单配置

安装TigerVNC server
yum install tigervnc-server
可选安装vnc client
yum install vnc

查看已安装 关键字为"vnc"的rpm包
rpm -qa |grep vnc

su cw
vncserver [第一次会提示你设置密码]

添加防火墙规则
iptables -A INPUT -p tcp -m tcp --dport 5901:5906 -j ACCEPT

至此你在客户端[VNC Viewer]就可以使用192.168.1.100:5901 访问这个linux系统了

------------------以下仅供参考-----------------------
cd /lib/systemd/system/
cp vncserver@.service vncserver@:1.service
vi vncserver@:1.service
41 ExecStart=/sbin/runuser -l cw -c "/usr/bin/vncserver %i -geometry 1024x768"

重载使配置文件生效
systemctl daemon-reload

设置vnc用户密码：
su cw
vncpasswd 或
[root@localhost ~]# vncpasswd cw

启动1号窗口：
su cw
vncserver 或
vncserver :1

查看当前用户开了几个窗口：
vncserver -list

关闭1号窗口：
vncserver -kill :1

开机启动：
systemctl enable vncserver@:1.service

-----------登录显示一个灰色桌面，和这三个复选框--------
vi .vnc/xstartup
#twm &
gnome-session &