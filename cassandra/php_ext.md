PHP 7.2.9 亲测可用

```
1. wget https://github.com/datastax/php-driver/archive/master.zip

2.依赖
wget https://downloads.datastax.com/cpp-driver/centos/7/cassandra/v2.12.0/cassandra-cpp-driver-2.12.0-1.el7.x86_64.rpm
wget https://downloads.datastax.com/cpp-driver/centos/7/cassandra/v2.12.0/cassandra-cpp-driver-devel-2.12.0-1.el7.x86_64.rpm

rpm -ivh cassandra-cpp-driver-2.12.0-1.el7.x86_64.rpm #1
rpm -ivh cassandra-cpp-driver-devel-2.12.0-1.el7.x86_64.rpm #2

3.编译
cd php-driver-master/ext
/data/apps/php/bin/phpize 
./configure --with-php-config=/data/apps/php/bin/php-config
make && make install

成功可得到 cassandra.so
```

参考

https://github.com/datastax/php-driver/blob/master/ext/README.md