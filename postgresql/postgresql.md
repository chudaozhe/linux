###Windows:
postgredql的php扩展(`php_pdo_pgsql.dll/php_pgsql.dll`)是通过`libpq.dll`与服务端通信的，所以如果php是64位，postgresql也得装64位版

> 注：`libpq.dll`在`D:\Program Files (x86)\PostgreSQL\9.4\bin`下面，需要将这个目录加入环境变量

###Linux
`wget(curl -O) https://ftp.postgresql.org/pub/source/v10.3/postgresql-10.3.tar.gz`

依赖包

`yum install readline-devel perl-ExtUtils-Embed tcl tcl-devel`

开始编译

`./configure --prefix=/data/apps/pgsql --with-pgport=5432 --with-perl --with-python --with-tcl`

`gmake && gmake install(make && make install)`

查看编译参数

`pg_config --configure`

添加系统用户postgres

	useradd postgres
	passwd postgres

<del>vi /etc/passwd</del>

<del>`似这样postgres:x:26:26:PostgreSQL Server:/var/lib/pgsql:/bin/bash`</del>


	cd /data/apps/pgsql
	mkdir data
	chown postgres data/
	
su - postgres

初始化数据库(-D 指定数据存放目录)

`/data/apps/pgsql/bin/initdb -D /data/apps/pgsql/data/`
	
	Success. You can now start the database server using:
	
	    /data/apps/pgsql/bin/postgres -D /data/apps/pgsql/data/
	or
	    /data/apps/pgsql/bin/pg_ctl -D /data/apps/pgsql/data/ -l /data/apps/pgsql/data/serverlog start

创建启动脚本

	cd /data/tgz/postgresql-9.4.0
	cp contrib/start-scripts/linux /etc/init.d/postgresql
	设置postgresql的安装目录
	vi /etc/init.d/postgresql
	chmod +x /etc/init.d/postgresql

默认日志文件为 `//data/serverlog`

`service postgresql {start|stop|restart|reload|status}`

设置软链

`ln -s /data/apps/pgsql/bin/* /usr/bin/`


开启远程链接

	vi postgresql.conf
	59 listen_addresses = '*'          # what IP address(es) to listen on;
	vi pg_hba.conf
	[只允许这一个ip登录]
	87 host    all             all             192.168.1.61/32         md5

开机启动

`chkconfig --level 345 postgresql on`

查看是否设置成功

`chkconfig |grep postgresql`

####使用
登录psql

`psql -U postgres`

给postgres设置密码



`\password`

创建用户

`CREATE USER cui WITH PASSWORD 'admin';`

创建数据库

`CREATE DATABASE hehe OWNER cui;`


将hehe数据库的所有权限都赋予cui，否则cui只能登录控制台，没有任何数据库操作权限

`GRANT ALL PRIVILEGES ON DATABASE hehe to cui;`


登录远程数据库

	psql -Upostgres -dtestdb -h192.168.1.9 -p5432
	
	-U指定用户，-d指定数据库，-h指定服务器，-p指定端口。

导入导出

	psql -Upostgres db1 < ./db1.sql
	pg_dump -hlocalhost -Upostgres db1 >./db1.sql

TEST

	[root@cw postgresql-9.4.0]# su - postgres
	-bash-4.1$ createdb test
	-bash-4.1$ psql test
	psql (9.4.0)
	Type "help" for help.
	
	test=# 
	test=# create table test(id int,uname char(30));
	test=# \d
	test=# insert into test values(1,'hehe');
	test=# select * from test;
	test=# \q

---------------

	[root@cw postgresql-9.4.0]# psql -U postgres
	默认是postgres用户是没有密码的可以直接登录，这里设个密码
	postgres=# \password
问题1：

`configure: error: could not determine flags for linking embedded Perl.
This probably means that ExtUtils::Embed or ExtUtils::MakeMaker is not
installed.`

解决：

`yum install perl-ExtUtils-Embed`