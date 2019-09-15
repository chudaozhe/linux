#!/usr/bin/env bash
dir="/vagrant/mysql/backup/$(date +%Y%m%d)";
filename="all_mysql$(date +%Y%m%d%H%M).sql.gz";
mkdir $dir
cd $dir
mysql -e "show databases;" -uroot | grep -Ev "Database|mysql|information_schema|performance_schema|tmp|phpmyadmin" > databases.txt
mysql -e "show databases;" -uroot | grep -Ev "Database|mysql|information_schema|performance_schema|tmp|phpmyadmin" | xargs mysqldump --skip-lock-tables -uroot --databases | gzip> $filename

