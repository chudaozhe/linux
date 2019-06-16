### 简单cql

```
#创建Keyspace:test2
CREATE KEYSPACE test2 WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 3 };
cqlsh> use test2;
#CURD
cqlsh:test2> CREATE TABLE user ( first_name text, last_name text, PRIMARY KEY (first_name));
#cqlsh:test2> CREATE TABLE test2.user ( first_name text, last_name text, PRIMARY KEY (first_name));
cqlsh:test2> insert into user(first_name, last_name) values('x', 'u');
cqlsh:test2> select * from user where first_name='x';
cqlsh:test2> update user set last_name='xxx' where first_name='x';
cqlsh:test2> delete from user where first_name='xx';

#将select等输出结果保存到文件里
cqlsh> CAPTURE '/vagrant/cql.log'
cqlsh> capture off; #关闭

cqlsh:test2> TRUNCATE user ;
cqlsh:test2> DROP TABLE user ;

#已创建的keyspaces
cqlsh> DESCRIBE keyspaces;
#keyspace下的所有表
cw@cqlsh:test111> desc tables;

#输出 test111 里面所有的表结构
cqlsh> DESCRIBE test111;
#输出user表的结构
cqlsh> DESCRIBE user
```

### 备份-copy

```
#keyspace: test111
#备份user表到csv
cqlsh> copy test111.user to '/vagrant/db.csv';
cqlsh> copy test111.user(id, name) to '/vagrant/db.csv';
#把csv导入到user表
cqlsh> copy test111.user from '/vagrant/db.csv' ;
```

### 备份-快照

快照可以手动创建，也可以自动创建(比如truncate时)

```
#快照列表
nodetool listsnapshots
#删除快照
nodetool clearsnapshot [-t 快照名称]
```

快照创建

```
#全库快照
nodetool -h 服务器ip -p 端口号 snapshot 数据库名
#某个表快照
nodetool -h 服务器ip -p 端口号 snapshot -t 快照名称 -kt 数据库名.表名

#为所有的keyspace创建快照，包括系统的
nodetool snapshot;
#生成整个test111 (keyspace)快照，快照名test111.2019 （快照文件分布在每个表的文件夹下）
nodetool snapshot -t test111.2019 -kt test111
#生成test111.user表快照，快照名xss_user
nodetool snapshot -t xss_user -kt test111.user;
```

快照恢复

```
1)/var/lib/cassandra/data/{keyspace}/{表名}/
2)/var/lib/cassandra/data/{keyspace}/{表名}/{snapshots}/{快照名称}/
2是1的备份，必要时可以拿2覆盖1

步骤
 #进入user表所在目录
 cd /var/lib/cassandra/data/test111/user-b2fb6a708eca11e99a8ce32b0946d0e3
 #1复制快照文件
 cp snapshots/test111.2019/* .
 chown -R cassandra: ./*
 #2刷新
 nodetool refresh -- test111 user
```

### 安全

```
 #启用密码验证
 vi /etc/cassandra/conf/cassandra.yaml
 103 authenticator: PasswordAuthenticator
 service cassandra restart
 #创建新用户
 [root@10 conf]# cqlsh 192.168.0.88 -ucassandra -pcassandra
 CREATE USER cw WITH PASSWORD '123456' SUPERUSER ;
 #删除用户
 cassandra@cqlsh> DROP USER cassandra
```

### 其他

```
cassandra 的数据文件路径
/var/lib/cassandra/data/


端口，默认9042
如启用start_rpc: true 端口就是9160


#cqlsh连接
cqlsh 192.168.0.88 9042 -ucw -p123456

#在使用命令的时候记得常用tab，会有自动补齐功能。

```

### 参考

https://blog.csdn.net/andybegin/article/details/78520333

https://zhaoyanblog.com/archives/307.html



