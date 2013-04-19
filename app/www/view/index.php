<?php
// xhrof start
if (isset($_GET['debug'])) {
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

    define('START_TIME', microtime(true));
    define('START_MEMORY_USAGE', memory_get_usage());
}

// The PHP file extension
define('EXT', '.php');

// define path
define('APPPATH', realpath(dirname(dirname(__DIR__))) . '/');
define('WEBPATH', realpath(__DIR__) . '/');
define('CACHEPATH', realpath(dirname(dirname(APPPATH))) . '/cache/www/');
//define('SYSPATH', realpath(dirname(APPPATH)) . '/Yeap/');
define('VENDORPATH', realpath(dirname(APPPATH)) . '/vendor/');

use Yeap\Base;

// use composer autoload file
require_once VENDORPATH . 'autoload.php';

// init system
$instance = new Base();
$instance->display();

// xhrof end
if (isset($_GET['debug'])) {
    $xhprof_data = xhprof_disable();

    echo "Page rendered in <b>"
        . round((microtime(true) - START_TIME), 5) * 1000 ." ms</b>, taking <b>"
        . round((memory_get_usage() - START_MEMORY_USAGE) / 1024, 2) ." KB</b>";
    $f = get_included_files();
    echo ", include files: ".count($f);
    
    $XHPROF_ROOT = realpath(dirname(__FILE__) .'/../../../..');
    include_once $XHPROF_ROOT . "/php-framework-benchmark/xhprof/xhprof_lib/utils/xhprof_lib.php";
    include_once $XHPROF_ROOT . "/php-framework-benchmark/xhprof/xhprof_lib/utils/xhprof_runs.php";
    
    // save raw data for this profiler run using default
    // implementation of iXHProfRuns.
    $xhprof_runs = new XHProfRuns_Default();
    
    // save the run under a namespace "xhprof_foo"
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");
    
    echo ", xhprof <a target='_blank' href=\"http://xhprof.pfb.example.com/xhprof_html/index.php?run=$run_id&source=xhprof_foo\">url</a>";
}
// end;