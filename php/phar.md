PHAR: 即 PHP Archive，将这个应用程序打包成单个文件，以利于分发和安装的机制，似乎是从JAVA的JAR借鉴来的东西


	phar/
	├── builder.php	#操作phar扩展，实现打包php文件
	├── demo			#要打包的目录
	│   └── boot.php
	├── my.phar		#生成的包
	└── test.php		#使用包

参考：

`http://my.oschina.net/ecnu/blog/132778`

`http://scar.tw/article/2013/01/09/php-phar-create-and-use/`

`http://blog.csdn.net/yonggang7/article/details/24142725`


