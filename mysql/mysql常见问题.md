----重置密码 start----
vi /etc/my.cnf
在[mysqld]的段中加上skip-grant-tables
service mysql restart
mysql -uroot -p
UPDATE mysql.user SET password = password('admin888') where user = 'root';

删除my.cnf中skip-grant-tables这一行
service mysql restart
----重置密码 end----

----如果可以进到mysql,设置新密码 start----
mysql> SET PASSWORD = PASSWORD('admin888');
FLUSH PRIVILEGES;
----如果可以进到mysql,设置新密码 end----

----将从库改为主库 start----
1,锁定主库，确保不会有数据写入，确保主从数据一致
2,取消从库角色(干净的清除Slave同步信息)
mysql> stop slave;
mysql> reset slave all;
mysql> show slave status\G;
Empty set (0.02 sec) 
3,修改my.cnf，重启mysql
----将从库提升为主库 end----