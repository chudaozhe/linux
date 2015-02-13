# cd rsync*
# ./configure --prefix=/data/apps/rsync
# make
# make install
# cd /data/apps/rsync/bin
# rsync -rv /home/wei/1cui/ /home/wei/2cui/
下载到本地：# rsync -rv root@42.121.117.132:/var/www/test /home/wei/Desktop/

将cuiwei.net上的~/Maildir目录【除了里的面.git目录和tmp目录】同步到当前目录里
1、rsync -rv --exclude=".git"  --exclude="tmp" cuiwei.net:~/Maildir .

2、rsync -rv --exclude-from=exclude.txt cuiwei.net:~/Maildir .
[root@cw]# cat exclude.txt 
.git 
tmp 
hehe* 