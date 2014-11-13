安装依赖包：
yum install ImageMagick ImageMagick-devel
一、配置rails+nginx
1、ruby
http://www.ruby-lang.org/en/downloads/
wget http://cache.ruby-lang.org/pub/ruby/2.1/ruby-2.1.2.tar.gz
tar -xvzf ruby-2.1.2.tar.gz
cd ruby-2.1.2
./configure --prefix=/data/apps/ruby
make && make install
ln -s /data/apps/ruby/bin/* /usr/bin
ruby -v
gem -v

2、升级rubygems
http://rubygems.org/pages/download
wget http://production.cf.rubygems.org/rubygems/rubygems-2.4.1.tgz
tar -xvzf rubygems-2.4.1.tgz
cd rubygems-2.4.1
ruby setup.rb
gem -v

3、rails[设置源见附1]
gem install rails -V
ln -s /data/apps/ruby/bin/* /usr/bin
rails -v

4、passenger
gem install passenger
[https://www.phusionpassenger.com/install_tarball
wget http://s3.amazonaws.com/phusion-passenger/releases/passenger-4.0.48.tar.gz]
ln -s /data/apps/ruby/bin/* /usr/bin
passenger -v

5、bundler
gem install bundler
ln -s /data/apps/ruby/bin/* /usr/bin
bundler -v
------------------
重新编译nginx加入passenger模块：
#查看path-to-passenger-root位置
passenger-config --root
#--add-module=/data/apps/ruby/lib/ruby/gems/2.1.0/gems/passenger-4.0.48/ext/nginx

cd /usr/local/src/nginx-1.7.0
./configure --prefix=/data/apps/nginx --user=www --group=www --prefix=/data/apps/nginx --conf-path=/data/apps/nginx/conf/nginx.conf --pid-path=/data/apps/nginx/logs/nginx.pid --with-http_stub_status_module --with-http_ssl_module --with-pcre=/usr/local/src/libs/pcre-8.35 --with-http_realip_module --with-http_image_filter_module --add-module=/data/apps/ruby/lib/ruby/gems/2.1.0/gems/passenger-4.0.48/ext/nginx
make
mv /data/apps/nginx/sbin/nginx /data/apps/nginx/sbin/nginx.old
cp objs/nginx /data/apps/nginx/sbin

二、配置redmine
wget http://www.redmine.org/releases/redmine-2.5.2.tar.gz
cd redmine[以下操作都在这个目录进行]
1、vi Gemfile
#source 'http://ruby.sdutlinux.org'

2、添加redmine数据库及用户权限设置：
CREATE DATABASE redmine CHARACTER SET utf8;
CREATE USER 'redmine'@'localhost' IDENTIFIED BY 'test168';
GRANT ALL PRIVILEGES ON redmine.* TO 'redmine'@'localhost';

3、cp config/database.yml.example  config/database.yml 

4、vi config/database.yml
production:
  adapter: mysql2
  database: redmine
  host: localhost
  username: redmine
  password: "test168"
  encoding: utf8

5、依赖项安装：
bundle install --without development test[报错见附2]

6、Session存储秘钥
rake generate_secret_token
7、数据库表结构初始化
# 生成表结构
RAILS_ENV=production rake db:migrate
# 初始化数据
RAILS_ENV=production rake redmine:load_default_data

后台执行：
nohup ruby script/rails server webrick -e production &
设置nginx转发3000端口

附1：
----------------选择一http://ruby.sdutlinux.org/--------------------------
gem sources --remove https://rubygems.org/
gem sources -a http://ruby.sdutlinux.org/
*** CURRENT SOURCES ***

http://ruby.sdutlinux.org
#请确保只有 ruby.sdutlinux.org
gem sources -l
[gem update --system]

----------------选择二http://ruby.taobao.org--------------------------

附2：
如果mysql是手动编译的，要指定mysql_config位置：
gem install mysql2 -- --with-mysql-config=/data/apps/mysql/bin/mysql_config

如果是yum装的，找不到libmysqlclient_r.so.16包就装MySQL-shared-compat rpm包:
#http://dev.mysql.com/get/Downloads/MySQL-5.7/MySQL-shared-compat-5.7.4_m14-1.el6.x86_64.rpm
