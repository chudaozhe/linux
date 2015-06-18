1、ruby
http://www.ruby-lang.org/en/downloads/
wget http://cache.ruby-lang.org/pub/ruby/2.2/ruby-2.2.2.tar.gz
tar -xvzf ruby-2.2.2.tar.gz
cd ruby-2.2.2
./configure --prefix=/data/apps/ruby
make && make install
ln -s /data/apps/ruby/bin/* /usr/bin
ruby -v
gem -v

2、如需升级gem
RubyGems（简称 gems）是一个用于对 Ruby组件进行打包的 Ruby 打包系统。 它提供一个分发 Ruby 程序和库的标准格式，还提供一个管理程序包安装的工具。
RubyGems的功能类似于Linux下的apt-get。使用它可以方便第从远程服务器下载并安装Rails。
打开命令行窗口(cmd)，输入执行命令 gem install rails --remote 或　gem install rails--include-dependencies。

http://rubygems.org/pages/download
wget http://production.cf.rubygems.org/rubygems/rubygems-2.4.8.tgz
tar -xvzf rubygems-2.4.8.tgz
cd rubygems-2.4.8
ruby setup.rb
gem -v
#卸载
gem uninstall softname

3、rails[设置源见附1]
rails(Ruby on Rails)是一个用于开发数据库驱动的网络应用程序的完整框架。Rails基于MVC（模型- 视图- 控制器）设计模式。从视图中的Ajax应用，到控制器中的访问请求和反馈，到封装数据库的模型，Rails 为你提供一个纯Ruby的开发环境。发布网站时，你只需要一个数据库和一个网络服务器即可。

gem install rails -V
ln -s /data/apps/ruby/bin/* /usr/bin
rails -v

4、passenger
Phusion Passenger，原名 mod_rails ，是一个旨在从Apache和Nginx网页服务器上更便捷的部署Ruby on Rails项目的web服务器模块。
gem install passenger
[https://www.phusionpassenger.com/install_tarball
wget http://s3.amazonaws.com/phusion-passenger/releases/passenger-5.0.10.tar.gz]
ln -s /data/apps/ruby/bin/* /usr/bin
passenger -v

5、bundler
gem依赖关系管理工具,它通过安装应用程序的Gemfile中的所有gem来做到这一点。
gem install bundler
ln -s /data/apps/ruby/bin/* /usr/bin
bundler -v

6、mysql2
gem install mysql2 -- --with-mysql-config=/data/apps/mysql/bin/mysql_config
测试用例:mysql2_test1.rb

附1：
----------------选择一http://ruby.sdutlinux.org/--------------------------
gem sources --remove https://rubygems.org/
gem sources -a http://ruby.sdutlinux.org/
#请确保只有 ruby.sdutlinux.org
gem sources -l
*** CURRENT SOURCES ***

http://ruby.sdutlinux.org
[gem update --system]

----------------选择二http://ruby.taobao.org--------------------------
