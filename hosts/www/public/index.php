<?php

// define path
define('DOMAIN', 'www');
define('WEBPATH', realpath(dirname(__DIR__)) . '/');
define('PROJECTPATH', realpath(dirname(WEBPATH).'/../') . '/');
define('VIEWPATH', WEBPATH . 'views/');
define('CTLPATH', WEBPATH . 'controllers/');
define('CLASSPATH', PROJECTPATH . '/classes/');
define('CACHEPATH', realpath(dirname(PROJECTPATH).'/') . '/cache/'.DOMAIN.'/');
define('VENDORPATH', PROJECTPATH . '/vendor/');

use Yeap\Base;

// use composer autoload file
require_once VENDORPATH . 'autoload.php';

// init system
$instance = new Base();
$instance->display();

// end;