简单安装：
#apt-get install git
#yum install git
源码编译：
依赖包：
yum install perl-ExtUtils-MakeMaker
yum install tcl
yum install gettext-devel

#wget https://www.kernel.org/pub/software/scm/git/git-2.1.2.tar.gz
#./configure --prefix=/data/apps/git
make && make install

#ln -s /data/apps/git/bin/* /usr/bin/
测试：
#git --version
#git clone git://git.kernel.org/pub/scm/git/git.git
参考：http://www.oschina.net/code/snippet_4873_1376

-------------服务端------------------
创建git用户
useradd git
su git
设置用户推送时免输git密码
cd ~
//使其自动创建.ssh目录
ssh-keygen -t rsa -C "chudaozhe@outlook.com"
echo "客户端用户的public key" >>authorized_keys
chmod 600 authorized_keys

开启服务端rsa验证：
vi /etc/ssh/sshd_config
13 Port 1018	#改掉22端口号，注意防火墙要开放此端口
47 RSAAuthentication yes
48 PubkeyAuthentication yes
49 AuthorizedKeysFile      .ssh/authorized_keys
66 PasswordAuthentication no  #禁止使用密码登录
/etc/init.d/sshd reload

[此时可在客户端测试：ssh git@192.168.9.110 如果免密码成功登录则说明这部分已配置成功]

建仓库：
mkdir -p work/project.git
cd project.git
git --bare init
[至此仓库的访问url为：git@192.168.9.110:~/work/project.git]

禁止用户使用git 远程ssh登录服务器：
git:x:504:504::/home/git:/usr/bin/git-shell

------------客户端----------------
生成 ssh keys
ssh-keygen -t rsa -C "chudaozhe@outlook.com"
...连连回车...
查看public key
cat ~/.ssh/id_rsa.pub
[将你的key发给管理员]
#配置个人信息
git config --global user.name "cw"
git config --global user.email "chudaozhe@outlook.com"

cd my_project
git init
touch hehe
git add .
git commit -m 'ok'
git remote add origin git@192.168.9.110:~/work/project.git
[备用git remote rm origin]
git push origin master

参考：
http://blog.chinaunix.net/uid-28621021-id-3487552.html

#查看当前状态
git status
=====增改三步走start=====
#添加
vi test.php
git add test.php #将新文件加到暂存区
#推到本地
git commit -m 'ok' #将暂存区里的文件提交
记住，提交时记录的是放在暂存区域的快照，任何还未暂存的仍然保持已修改状态，可以
在下次提交时纳入版本管理。每一次运行提交操作，都是对你项目作一次快照，以后可以回
到这个状态，或者进行比较。

#推到服务器(github)
#git push
git push -u origin master
=====增改三步走end=====

=====修改已被git管理的文档=====
修改:
vi test.php
git add test.php #将本次修改加到暂存区
(记住，如果只是修改或者删除了已被Git管理的文档，是没必要使用git-add 命令的)

=====删除=====
git rm test.php
git rm --cached test.php #只删除暂存区的，工作目录里保留

#查看提交日志
git log
#查看单个文件的提交日志
git log --pretty=oneline 文件名
#查看add前的修改
git diff
#拉取到本地
git pull
