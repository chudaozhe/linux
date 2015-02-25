SVN创建版本库，新建用户
查看进程里是否有'svn'[判断svn服务是否启动]
ps aux | grep svn*
启动svn服务
-d [--daemon]            : 后台模式
-r [--root] ARG          : 服务的根目录

/usr/bin/svnserve -d -r /data/svn
创建ios版本库
1、svnadmin create /data/svn/ios/
2、vi conf/passwd
[users]
# 用户名 = 密码
test1 = test111
test2 = test222

3、vi conf/svnserve.conf
[general]
anon-access = none
auth-access = write
password-db = passwd
authz-db = authz
realm = /data/svn/ios

4、vi conf/authz
[groups]
#定义组 admin 包含 test1 和 test2 两个用户
admin = test1,test2

[/]
#定义群组 admin 有读写权限
@admin=rw
#以上没有定义的用户都没有任何权限
* = 

附：
http://www.kankanews.com/ICkengine/archives/115356.shtml
http://blog.slogra.com/post-193.html
---------------客户端连接URL-----------------
svn://test1@192.168.1.6/ios