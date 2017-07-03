## 说明： ##

服务器操作系统：CentOS 7 64位

## 步骤 ##
1、安装iptables, pptpd

	yum install -y pptpd ppp iptables iptables-services

2、启用IP路由转发

	vi /etc/sysctl.conf
	
	net.ipv4.ip_forward = 1  #设置为1
	#net.ipv4.tcp_syncookies = 1  #注释掉

使立即生效：

	sysctl -p

3、设置dns

	vi /etc/ppp/options.pptpd

	ms-dns 8.8.8.8
	ms-dns 8.8.4.4


4、设置pptp服务器IP地址，设置vpn拨入客户端ip地址池

	vi /etc/pptpd.conf

	localip 172.16.36.1 #设置pptp虚拟拨号服务器IP地址（注意：不是服务器本身的IP地址）
	remoteip 172.16.36.2-254 #为拨入vpn的用户动态分配172.16.36.2～172.16.36.254之间的IP地址


5、添加帐号

	vi /etc/ppp/chap-secrets

	# Secrets for authentication using CHAP
	# client        server  secret                  IP addresses
	chudaozhe	pptpd	123456	*



6、iptables

	禁止firewalld：
	systemctl stop firewalld.service
	systemctl disable firewalld.service
	firewall-cmd --state

	iptables -t nat -A POSTROUTING -s 172.16.36.0/255.255.255.0 -j SNAT --to-source 10.144.xx.xx(腾讯云是内网ip/阿里云是外网ip)
	iptables -A FORWARD -p tcp --syn -s 172.16.36.0/255.255.255.0 -j TCPMSS --set-mss 1356
	保存规则：
	service iptables save
	

----------


重启服务

	systemctl restart pptpd.service
	systemctl restart iptables.service

开机自启

	systemctl enable iptables.service
	systemctl enable pptpd.service

参考

	http://www.osyunwei.com/archives/7407.html