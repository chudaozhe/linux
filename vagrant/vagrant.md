## 准备 ##
	下载vagrant
	https://www.vagrantup.com/downloads.html
	下载virtualbox
	https://www.virtualbox.org/wiki/Downloads
	下载镜像box
	http://www.vagrantbox.es/

## 开始 ##
	进入项目目录(启动后系统自动挂载该目录到/vagrant)
	cd vagrant

	1,添加本地box
	vagrant box add base D:\Users\home\Downloads\centos-6.6-x86_64.box
	2,初始化
	vagrant init
	3,启动
	vagrant up
	4,连接
	vagrant ssh

## 常用操作 ##

	重新加载配置文件
	vagrant reload

	打包
	vagrant package
	
	关闭
	vagrant halt
	
	关闭虚拟机并完全删除它
	vagrant destroy

	暂停机器，保存当前状态
	vagrant suspend

	继续运行之前暂停的机器
	vagrant resume

	状态
	vagrant status

## 其他 ##
	vagrant plugin install vagrant-vbguest
添加的box会占用两个目录

	D:\VirtualBox VMs #VirtualBox默认虚拟机位置
	C:\Users\wei\.vagrant.d\boxes
## 常见问题 ##

1，验证失败

	default: Warning: Authentication failure. Retrying...
解决办法：

先vagrant up 启动。然后看到Retrying...之后Ctrl＋C。这时候虚拟机其实已经启动了。
然后运行vagrant ssh会让你输入密码。如果正常的话密码应该也是vagrant。进入.ssh目录，把authorized_keys的权限改为600

2，挂载失败：

	Vagrant was unable to mount VirtualBox shared folders. This is usually because the filesystem "vboxsf" is not available. This filesystem is made available via the VirtualBox Guest Additions and kernel module. Please verify that these guest additions are properly installed in the guest. This is not a bug in Vagrant and is usually caused by a faulty Vagrant box. For context, the command attemped was:

解决办法：

	sudo /etc/init.d/vboxadd setup

## puphpet ##
开发环境自动部署工具

	https://puphpet.com/

1, 修改ruby源

	http://ruby.sdutlinux.org/

2, 修改pypi(python)源

	https://pypi-mirrors.org/

3, 指定本地box

	vi puphpet/config.yaml
	box_url: D:\Users\home\Downloads\centos-6.6-x86_64.box
## 参考 ##

	http://apexy.logdown.com/posts/138626-god-of-programmers-tool-vagrant


## Chef ##
 是一款自动化服务器配置管理工具