----重置密码 start----
vi /etc/my.cnf
在[mysqld]的段中加上skip-grant-tables
service mysql restart
mysql -uroot -p
UPDATE mysql.user SET password = password('admin888') where user = 'root';

删除my.cnf中skip-grant-tables这一行
service mysql restart
----重置密码 end----

----如果可以进到mysql,设置新密码 start----
mysql> SET PASSWORD = PASSWORD('admin888');
FLUSH PRIVILEGES;
----如果可以进到mysql,设置新密码 end----
