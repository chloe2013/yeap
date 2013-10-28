#! /bin/sh
case $# in
0) 
    echo "-----------------------------------------------------------------------------" 
    echo "[USAGE]" 
    echo "   ./nginx.sh [start|stop|restart]" 
    echo "-----------------------------------------------------------------------------" 
;;
1)
    if [ $1 = "start" ]
    then
        echo "Starting nginx server..." 
        /usr/local/nginx/sbin/nginx > /dev/null 2>&1
        #/usr/local/php/sbin/php-fpm start 
		/etc/init.d/php-fpm start 
    elif [ $1 = "stop" ]
    then
        echo "Stopping nginx server..." 
        /usr/local/nginx/sbin/nginx -s stop > /dev/null 2>&1
        #/usr/local/php/sbin/php-fpm stop 
		/etc/init.d/php-fpm stop
    elif [ $1 = "restart" ]
    then
        echo "Restarting nginx server..."        
        /usr/local/nginx/sbin/nginx -s reload > /dev/null 2>&1
        #/usr/local/php/sbin/php-fpm restart 
		/etc/init.d/php-fpm restart
    else
        echo "-----------------------------------------------------------------------------" 
        echo "[USAGE]" 
        echo "   ./nginx.sh [start|stop|restart]" 
        echo "-----------------------------------------------------------------------------" 
    fi
;;
*)
    echo "-----------------------------------------------------------------------------" 
    echo "[USAGE]" 
    echo "   ./nginx.sh [start|stop|restart]" 
    echo "-----------------------------------------------------------------------------" 
;;
esac
