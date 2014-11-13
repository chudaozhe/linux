192.168.9.104
yum -y install samba
smbd start / /etc/init.d/smb start
service smb status
chkconfig --level 35 smb on

groupadd cwsmb
useradd -g cwsmb cui
passwd cui
smbpasswd -a cui

cd /etc/samba/
cp smb.conf smb.conf.bak

----------workgroup工作组都可访问-----------
mkdir /share
chown -R nobody:nobody /share/
find www/ -type d -exec setfacl -m g:cwsmb:rwx {} \;
find www/ -type f -exec setfacl -m g:cwsmb:rw {} \;

清除window登录samba的记录命令如下：
•net use  * /del
