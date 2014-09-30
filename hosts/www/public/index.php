<?php

if (isset($_GET['debug'])) {
    xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    define('START_TIME', microtime(true));
    define('START_MEMORY_USAGE', memory_get_usage());
}


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

if (isset($_GET['debug'])) {
    $xhprof_data = xhprof_disable();

    echo "Page rendered in <b>"
        . round((microtime(true) - START_TIME), 5) * 1000 ." ms</b>, taking <b>"
        . round((memory_get_peak_usage()) / 1024, 2) ." KB</b>";
    $f = get_included_files();
    echo ", include files: ".count($f);

    require_once VENDORPATH . "xhprof/lib/utils/xhprof_lib.php";
    require_once VENDORPATH . "xhprof/lib/utils/xhprof_runs.php";

    // save raw data for this profiler run using default
    // implementation of iXHProfRuns.
    $xhprof_runs = new \XHProfRuns_Default();

    // save the run under a namespace "xhprof_foo"
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

    echo ", xhprof <a target='_blank' href=\"http://xhprof.yeap.dev/index.php?run=$run_id&source=xhprof_foo\">url</a>";
}

// end;