<?php
define('DEBUG', TRUE);

// xhrof start
if (DEBUG) {
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

    define('START_TIME', microtime(true));
    define('START_MEMORY_USAGE', memory_get_usage());
}

// define path
define('WEBPATH', realpath(dirname(__DIR__)) . '/');
define('VIEWPATH', WEBPATH . 'View/');
define('CTLPATH', WEBPATH . 'Controller/');
define('DOMAIN', 'Www');
define('APPPATH', realpath(dirname(WEBPATH)) . '/');
define('CACHEPATH', realpath(dirname(dirname(APPPATH))) . '/cache/www/');
define('VENDORPATH', realpath(dirname(APPPATH)) . '/vendor/');

use Yeap\Base;

// use composer autoload file
require_once VENDORPATH . 'autoload.php';

// init system
$instance = new Base();
$instance->display();

// end;