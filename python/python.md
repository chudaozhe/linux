	wget https://www.python.org/ftp/python/3.4.3/Python-3.4.3.tar.xz
	yum install xz
	tar -xvJf Python-3.4.3.tar.xz
	cd Python-3.4.3
	
	./configure --prefix=/data/apps/python3
	make && make install
	
	mv /usr/bin/python /usr/bin/python_old 
	rm /usr/bin/python2
	ln -s /usr/bin/python.old /usr/bin/python2

	ln -s /data/apps/python3/bin/* /usr/bin/
	ln -s /data/apps/python3/bin/python3 /usr/bin/python



yum不支持python3,需指定python2

	vi /usr/bin/yum
	#!/usr/bin/python_old


