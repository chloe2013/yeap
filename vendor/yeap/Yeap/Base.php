<?php
/**
 * Base
 * base file for index.php
 * 
 * @package     Yeap
 * @author      Chloe <chloeye13@gmail.com>
 * @license     http://www.yeapframework.com/license
 * @version     1.0
 ********************************** 80 Columns *********************************
 */
namespace Yeap;

use Yeap\Config;
use Yeap\Router;
use Yeap\Exception\YeapException;
use \Exception;

// The PHP file extension
define('EXT', '.php');
define('DS', '/');

Class Base
{
    public function __construct()
	{
	}
	
	/**
	 * 最终输出显示
	 */
	public function display()
	{
		try {
			$config = new Config('base');
			$router = new Router($config);
			$router->load();
		}	
		catch (Exception $e) {
			// todo error handler	
			echo $e->getMessage();die;
		}
		
		self::debugEnd();
	}
	
	public static function debugStart()
	{
		
	}
	
	/**
	 * 结束
	 */
	public static function debugEnd()
	{
		if (DEBUG) {
		    $xhprof_data = xhprof_disable();
		
		    echo "Page rendered in <b>"
		        . round((microtime(true) - START_TIME), 5) * 1000 ." ms</b>, taking <b>"
		        . round((memory_get_usage() - START_MEMORY_USAGE) / 1024, 2) ." KB</b>";
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
	}
	
}

// End;