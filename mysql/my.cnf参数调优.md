[mysqld]
#修改最大连接数，查看# /usr/bin/mysqladmin -uroot -p variables |grep max_connections
set-variable=max_connections=1500  
character-set-server = utf8
collation-server = utf8_general_ci
#default-storage-engine=innodb
# 指定缓存目录
tmpdir="E:/phpStudy/tmp/"
# MyISAM表发生变化时重新排序所需的缓冲
myisam_sort_buffer_size = 128M
# MySQL重建索引时所允许的最大临时文件的大小
myisam_max_sort_file_size = 10G
# 单表缓存文件大小，大量group by可以调大一点
tmp_table_size=2048M
# mysql慢查询
log-slow-queries = "E:/phpStudy/tmp/mysql/mysqlslowquery.log"
long_query_time = 2

[client]
default-character-set=utf8

