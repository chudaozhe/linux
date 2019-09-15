编译参数

./configure --prefix=/data/apps/proftpd --sysconfdir=/etc --enable-openssl --with-modules=mod_sftp

公钥目录

/data/apps/proftpd/authorized_keys

如:登陆ftp用户名：cui

转换本地公钥, 然后上传到服务器
ssh-keygen -e -f ~/.ssh/id_rsa.pub > ./cui
scp cui root@ip:/data/apps/proftpd/authorized_keys/cui


FileZilla 设置

私钥：设置->sftp->添加私钥(~/.ssh/id_rsa) 或

在新建链接时：

sftp协议

登陆类型: 秘钥文件
用户: cui
秘钥文件: ~/.ssh/id_rsa



问题

服务器端移除客户端的公钥后，在客户端未断开链接时 还能继续使用？