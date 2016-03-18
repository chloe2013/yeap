@echo off
set file=%1

set local=%file:\=/%

set remote=%local:C:/Users/chloe/www=/home%

ssh www@172.192.3.211 'phpunit %remote%'