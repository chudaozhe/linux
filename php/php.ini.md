##Language Options

\#设置可执行php的目录，多个目录用冒号隔开<br>
379	open_basedir = /data/www


##Error handling and logging

\#错误级别<br>
521 error_reporting = E_ALL & ~E_DEPRECATED

\#禁止把错误输出到页面<br>
538 display_errors = Off

\#设置错误信息输出到文件<br>
559 log_errors = On

\#指定错误日志文件存储位置<br>
646 error_log = /data/logs/php_errors.log


## Data Handling

\#POST数据所允许的最大大小<br>
740 post_max_size = 300M


## File Uploads

\#是否允许文件上传On/Off<br>
882 file_uploads = On

\#上传文件放置的临时目录<br>
887 upload_tmp_dir = /data/tmp

\#上传的文件的最大大小<br>
891 upload_max_filesize = 200M

\#最多上传多少个文件<br>
894 max_file_uploads = 20


##Module Settings

\#设置时区<br>
1010 date.timezone = PRC


\#设置session存储方式 files/memcache/redis<br>
1463 session.save_handler = files

\#设置session文件存储位置"tcp://host1:11211?persistent=1&weight=1&timeout=1&retry_interval=15"<br>
1492 session.save_path = "/data/tmp"