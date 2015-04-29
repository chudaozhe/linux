[mysqld]
#开启二进制日志
log-bin=mysql-bin
server-id=200

replicate_wild_ignore_table=mysql.%	①

#master->slave1->slave11 这种结构才需开启此参数(为了slave1也能充当master，写relay-log的时候也会写到bin-log)
##log-slave-updates



备注：
①	参考：http://liuzf.blog.51cto.com/2739963/1134797/
#有安全问题的设置：
#要同步的数据库的名字
##replicate-do-db=test
#排除指定库，同步其他库
##replicate-ignore-db=mysql

#替代(replicate-do-db,replicate-ignore-db和binlog-do-db,binlog-ignore-db)方案：
#只需在Slave上设置(只同步test库)
replicate_wild_do_table=test.%
#或(同步mysql之外的库)
replicate_wild_ignore_table=mysql.%