wget http://stedolan.github.io/jq/download/source/jq-1.4.tar.gz
tar -xvzf jq-1.4.tar.gz
cd jq-1.4
./configure --prefix=/data/apps/jq
make && make install
#添加到可直接执行的目录 ##usr/bin目录:主要放置一些应用软件工具的必备执行档
ln -s /data/apps/jq/bin/jq /usr/bin/jq

使用：
vi test.txt
{"name":"Google","location":{"street":"1600 Amphitheatre Parkway","city":"Mountain View","state":"California","country":"US"},"employees":[{"name":"Michael","division":"Engineering"},{"name":"Laura","division":"HR"},{"name":"Elise","division":"Marketing"}]} 
less test.txt | jq .
less test.txt | jq .name
less test.txt | jq .employees[0].name

##jq还有一些内建函数如 key,has
#key是用来获取JSON中的key元素的
cat test.txt | jq 'keys'
#has是用来是判断是否存在某个key:
cat test.txt | jq 'has("name")'
curl http://news.at.zhihu.com/api/1.1/news/latest >zhihu
less zhihu | jq .

curl http://m.weather.com.cn/data/101010100.html |jq .weatherinfo.city

