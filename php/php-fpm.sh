#!/bin/sh  
# DateTime: 2013-09-16
# Author: lianbaikai
# site:http://www.ttlsa.com/html/3039.html
# chkconfig:   - 84 16   
# Source function library.  
. /etc/rc.d/init.d/functions  

# Source networking configuration.  
. /etc/sysconfig/network  

# Check that networking is up.  
[ "$NETWORKING" = "no" ] && exit 0  

phpfpm="/data/apps/php/sbin/php-fpm"  
prog=$(basename ${phpfpm})  

lockfile=/var/lock/subsys/phpfpm

start() {  
    [ -x ${phpfpm} ] || exit 5  
    echo -n $"Starting $prog: "  
    daemon ${phpfpm}
    retval=$?  
    echo  
    [ $retval -eq 0 ] && touch $lockfile  
    return $retval  
}  

stop() {  
    echo -n $"Stopping $prog: "  
    killproc $prog -QUIT  
    retval=$?  
    echo  
    [ $retval -eq 0 ] && rm -f $lockfile  
    return $retval  
}  

restart() {  
    configtest || return $?  
    stop  
    start  
}  

reload() {  
    configtest || return $?  
    echo -n $"Reloading $prog: "  
    killproc ${phpfpm} -HUP  
    RETVAL=$?  
    echo  
}  

force_reload() {  
    restart  
}  

configtest() {  
  ${phpfpm} -t
}  

rh_status() {  
    status $prog  
}  

rh_status_q() {  
    rh_status >/dev/null 2>&1  
}  

case "$1" in  
    start)  
        rh_status_q && exit 0  
        $1  
        ;;  
    stop)  
        rh_status_q || exit 0  
        $1  
        ;;  
    restart|configtest)  
        $1  
        ;;  
    reload)  
        rh_status_q || exit 7  
        $1  
        ;;  
    status)  
        rh_status  
        ;;  
    *)  
        echo $"Usage: $0 {start|stop|status|restart|reload|configtest}"  
        exit 2  
esac