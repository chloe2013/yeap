#!/bin/bash
export APP_INCLUDE=resque/require.php
export QUEUE=*
export COUNT=1
export VVERBOSE=1 # for debugging
export REDIS_BACKEND=localhost:6379
. /etc/rc.d/init.d/functions

start() {
    /usr/bin/php ../lib/sdk/php-resque/resque.php
}

stop() {
    ps -ef | grep resque | grep -v grep | grep -v resque-web | awk '{print $2}' | xargs kill -15
}
kill() {
    ps -ef | grep resque | grep -v grep | grep -v resque-web | awk '{print $2}' | xargs kill -9
}
case "$1" in
    start)
         number=$(ps aux | grep php-resque/resque.php | grep -v grep | wc -l)
        if [ $number -gt 0 ]
        then
          echo "php-resque is running. ($number workers)"
          echo "You may wanna stop them before you start."
        else
          start
        fi
    ;;

    stop)
        stop
    ;;

    kill)
        kill
    ;;

    status)
        number=$(ps aux | grep php-resque/resque.php | grep -v grep | wc -l)
        if [ $number -gt 0 ]
        then
          echo "php-resque is running. ($number workers)"
        else
          echo "php-resque is not running."
        fi
    ;;

    *)
        echo -n "Usage: $0 {start|stop|status}"
esac