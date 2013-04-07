<?php

// app real path
define('APP_PATH', realpath(dirname(dirname(__DIR__))) . '/');
define('YEA_PATH', realpath(dirname(APP_PATH)) . '/yeap/');
define('VENDOR_PATH', realpath(dirname(APP_PATH)) . '/vendor/');

use Yeap\Base;

require_once VENDOR_PATH . 'autoload.php';

$instance = new Base();

// end;