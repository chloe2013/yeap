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
			$config = Config::load('base');
			$router = new Router($config);
			$router->load();
		}	
		catch (Exception $e) {
			// todo error handler	
			echo $e->getMessage();die;
		}
	}
	
	
}

// End;