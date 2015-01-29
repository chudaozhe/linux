###Windows:
postgredql的php扩展(`php_pdo_pgsql.dll/php_pgsql.dll`)是通过`libpq.dll`与服务端通信的，所以如果php是32位，postgresql也得装32位版

> 注：`libpq.dll`在`D:\Program Files (x86)\PostgreSQL\9.4\bin`下面，需要将这个目录加入环境变量


####使用
给postgres设置密码

`\password postgres`

创建用户

`CREATE USER cui WITH PASSWORD 'admin';`

创建数据库

`CREATE DATABASE hehe OWNER cui;`


将hehe数据库的所有权限都赋予cui，否则cui只能登录控制台，没有任何数据库操作权限

`GRANT ALL PRIVILEGES ON DATABASE hehe to cui;`