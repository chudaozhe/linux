cd /data/tgz
wget(curl -O) http://downloads.mongodb.org/linux/mongodb-linux-x86_64-2.6.7.tgz
tar -xvzf mongodb-linux-x86_64-2.6.7.tgz
mv mongodb-linux-x86_64-2.6.7 /data/apps/mongodb

cd /data/apps/mongodb
mkdir data
mkdir logs

vi mongodb.conf
port=27017
dbpath=data/
logpath=logs/mongodb.log
logappend=true
fork=true
#安全验证
auth=true
#开启一个web服务127.1:28017
rest=true

启动服务
./bin/mongod -f mongodb.conf