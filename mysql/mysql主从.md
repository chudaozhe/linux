主ip：192.168.1.101
从ip：192.168.1.102

设置主
vi /data/apps/mysql/my.cnf
[mysqld]
#开启二进制日志
log-bin=mysql-bin
server-id=100


进入主mysql
#创建一个只允许ip192.168.1.102访问的backup用户并授权
grant replication slave on *.* to 'backup'@'192.168.1.102' identified by '123456';

#权限重载
FLUSH PRIVILEGES;

#验证一下
select user,host from mysql.user;

#锁定所有库(只能读取(库,表,记录值)，不能新建,删除,修改)
mysql> FLUSH TABLES WITH READ LOCK;

#查询主数据库状态，并记下FILE及Position的值

mysql> show master status;
+------------------+----------+--------------+------------------+-------------------+
| File             | Position | Binlog_Do_DB | Binlog_Ignore_DB | Executed_Gtid_Set |
+------------------+----------+--------------+------------------+-------------------+
| mysql-bin.000001 |     336  |              |                  |                   |
+------------------+----------+--------------+------------------+-------------------+
1 row in set (0.00 sec)


#选择要同步的主库并备份数据
[root@localhost mysql]# mysqldump -uroot -p test> ~/test.sql

#再次验证一下
mysql> show master status;

#解除表锁定
mysql> unlock tables;

#复制数据到slave
[root@localhost mysql]# scp test.sql root@192.168.1.102:~/


设置从
---导入从主备份过来的sql文件----

vi /data/apps/mysql/my.cnf
[mysqld]
#开启二进制日志
log-bin=mysql-bin
server-id=200

#创建一个只允许192.168.1.101访问的backup用户并授权
mysql>change master to master_host='192.168.1.101',master_user='backup',master_password='654321',master_log_file='mysql-bin.000001',master_log_pos=336;

注意：mysql-bin.000001(File的值)和master_log_pos(Position的值)是在主服务器上查询的 mysql>show master status;

启动同步
mysql>start slave;
mysql>show slave status\G   #末尾不加分号

#看一下，以下两件参数都是Yes才说明可以
	Slave_IO_Running=Yes [如果是Connecting说明不成功]
	Slave_SQL_Running=Yes

#如果要重复执行mysql>change master to... 需要停止同步mysql>stop slave 再执行
