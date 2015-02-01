下载php扩展包
http://www.ijg.org/files/jpegsrc.v9a.tar.gz
http://sourceforge.net/projects/libpng/files/libpng16/1.6.16/libpng-1.6.16.tar.gz
http://ftp.twaren.net/Unix/NonGNU//freetype/freetype-2.4.0.tar.gz
http://curl.haxx.se/download/curl-7.37.1.tar.gz
ftp://mcrypt.hellug.gr/pub/crypto/mcrypt/libmcrypt/libmcrypt-2.5.7.tar.gz
https://bitbucket.org/libgd/gd-libgd/downloads/libgd-2.1.0.tar.gz

下载php
http://tw1.php.net/distributions/php-5.6.4.tar.gz

也可以批量下载[一个url占一行]：
vi url-list.txt
cat url-list.txt | xargs wget -c

cd /data/apps/libs
mkdir jpegsrc libpng freetype curl libmcrypt #可以省略

./configure --prefix=/data/apps/libs --enable-shared --enable-static
./configure --prefix=/data/apps/libs 
./configure --prefix=/data/apps/libs
./configure --prefix=/data/apps/libs
./configure --prefix=/data/apps/libs
./configure --prefix=/data/apps/libs --with-png=/data/apps/libs --with-freetype=/data/apps/libs --with-jpeg=/data/apps/libs

make && make install

卸载yum装的Php：
yum remove php*

./configure --with-apxs2[=/usr/sbin/apxs] \ #备注1
--prefix=/data/apps/php \
--with-config-file-path=/data/apps/php/etc \
--with-mysql=mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd \
--with-iconv-dir --with-freetype-dir=/data/apps/libs \
--with-jpeg-dir=/data/apps/libs --with-png-dir=/data/apps/libs --with-zlib --with-libxml-dir=/data/apps/libs --enable-xml \
--disable-rpath --enable-bcmath --enable-shmop --enable-sysvsem \
--enable-inline-optimization --with-curl=/data/apps/libs --enable-mbregex \
--enable-mbstring --with-mcrypt=/data/apps/libs --with-gd=/data/apps/libs --enable-gd-native-ttf --with-openssl \
--with-mhash --enable-pcntl --enable-sockets --with-ldap-sasl \
--with-xmlrpc --enable-zip --enable-soap --with-pear --with-zlib [--with-pgsql=/data/
apps/pgsql  --with-pdo-pgsql=/data/apps/pgsql] [--enable-fpm] #备注2
make && make install 
cp php.ini-production /data/apps/php/etc/php.ini
------------------php-fpm nginx用 start---------------
cd /data/apps/php/etc
cp php-fpm.conf.default php-fpm.conf
启动php-fpm :
ln -s /data/apps/php/sbin/php-fpm /usr/bin/php-fpm
php-fpm
推荐使用启动脚本：[自带的/usr/local/src/php-5.5.11/sapi/fpm]
vi /etc/init.d/php-fpm 详见附1
chmod +x /etc/rc.d/init.d/php-fpm
开机启动：
chkconfig --level 345 php-fpm on
查看：
chkconfig --list php-fpm
------------------php-fpm end---------------
最后在httpd.conf中增加[使用php语法解析哪些后缀的文件]
AddType application/x-httpd-php .php .jsp .do

备注1：
1.如果httpd是yum安装的,apxs2可以不指定路径 2.如果找不到apxs可以yum install httpd-devel安装
3. --with-apxs2 该选项体现在：
/usr/lib64/httpd/modules/目录下增加libphp5.so文件
并在httpd.conf 中增加一行加载该文件
LoadModule php5_module        /usr/lib64/httpd/modules/libphp5.so
备注2：
注意：--with-apxs2和 --enable-fpm两个选项只能二选其一 否则会有如下错误：
+--------------------------------------------------------------------+
|                        *** ATTENTION ***                           |
|                                                                    |
| You've configured multiple SAPIs to be build. You can build only   |
| one SAPI module and CLI binary at the same time.                   |
+--------------------------------------------------------------------+
建议：--with-apxs2与apache一起， --enable-fpm[激活 FPM 支持]与nginx一起

php扩展：
bcompiler：加密php脚本,仅支持php5.3及以下版本,安装方法参见memcache扩展

问题1：
checking for known struct flock definition... configure: error: Don't know how to define struct flock on this system, set --enable-opcache=no
新建 local.conf
vi /etc/ld.so.conf.d/local.conf
加入以下两行
/usr/local/lib
/data/apps/libs/lib
保存退出
ldconfig -v 使生效