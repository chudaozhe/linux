[mysqld]
#开启二进制日志
log-bin=mysql-bin
server-id=100

①



备注：
①	参考：http://liuzf.blog.51cto.com/2739963/1134797/
同步库过滤：
#有安全问题的设置
#指定binlog日志记录那些库的二进制日志(需要同步的库)
##binlog-do-db=db1
##binlog-do-db=db2
#或记录mysql之外库的binlog日志
##binlog-ignore-db=mysql

#替代(replicate-do-db,replicate-ignore-db和binlog-do-db,binlog-ignore-db)方案：
#只需在Slave上设置(只同步test库)
replicate_wild_do_table=test.%
#或(同步mysql之外的库)
replicate_wild_ignore_table=mysql.%