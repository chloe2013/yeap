<?php

// app real path
define('APP_PATH', realpath(dirname(dirname(__DIR__))) . '/');
define('WEB_PATH', realpath(__DIR__) . '/');
define('CACHE_PATH', realpath(dirname(dirname(APP_PATH))) . '/cache/www/');
define('YEA_PATH', realpath(dirname(APP_PATH)) . '/Yeap/');
define('VENDOR_PATH', realpath(dirname(APP_PATH)) . '/vendor/');

use Yeap\Base;

require_once VENDOR_PATH . 'autoload.php';

$instance = new Base();


// end;