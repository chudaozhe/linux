#!/bin/bash

#从机ip
HOSTS=(
172.16.1.174
172.16.1.195
)
RSYNC_HOME=/data/apps/rsync/
INOTIFY_HOME=/data/apps/inotify-tools/

#要同步的目录
src=/data/www/test/
des=web160
#操作用户
user=hehe

${INOTIFY_HOME}bin/inotifywait -mrq --timefmt '%d/%m/%y %H:%M' --format '%T %w%f%e' -e modify,delete,create,attrib @"${INOTIFY_HOME}etc/exclude.txt" $src | while read files
do
${RSYNC_HOME}bin/rsync -vzrtopg --delete --progress --password-file=${RSYNC_HOME}etc/rsync.master.passwd --exclude-from=${RSYNC_HOME}etc/exclude.txt $src $user@${HOSTS[0]}::$des
${RSYNC_HOME}bin/rsync -vzrtopg --delete --progress --password-file=${RSYNC_HOME}etc/rsync.master.passwd --exclude-from=${RSYNC_HOME}etc/exclude.txt $src $user@${HOSTS[1]}::$des
echo "${files} was rsynced" >>${RSYNC_HOME}log/rsync.log 2>&1
done
