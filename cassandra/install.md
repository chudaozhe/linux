yum安装

1.1	 `vi /etc/yum.repos.d/cassandra.repo`

```
[cassandra] 
name=Apache Cassandra 
baseurl=https://www.apache.org/dist/cassandra/redhat/311x/ 
gpgcheck=1 
repo_gpgcheck=1 
gpgkey=https://www.apache.org/dist/cassandra/KEYS
```

1.2	`yum install cassandra`

2,修改配置文件

2.1	`vi /etc/cassandra/conf/cassandra.yaml`

```
  425           - seeds: "192.168.0.88"
  599 listen_address: 192.168.0.88
  676 rpc_address: 192.168.0.88
```

3,重启`service cassandra restart `

```
cqlsh 192.168.0.88:9042
```

客户端

```
JetBrains DataGrip
```

参考

https://cassandra.apache.org/download/