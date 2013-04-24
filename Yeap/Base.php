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
use Yeap\Exceptions;
use \Exception;

define('DS', '/');

Class Base
{
    private $url 	= '/';
	private $is_ajax = FALSE;
	private $tpl 	= null;
	private $config = null;
	private $db 	= null;
	private $router = null;
	
    public function __construct()
	{
		$this->url = parse_url(getenv('REQUEST_URI'), PHP_URL_PATH);
		$this->is_ajax = strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest';
		$this->config = new Config('base');
	}
	
	/**
	 * 最终输出显示
	 */
	public function display()
	{
		try {
			$path = trim($this->url, '/');
			$this->router = new Router($path, $this->config);
			$this->router->load();
		}	
		catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	/**
	 * post 方法 处理
	 */
	public function post()
	{
		
	}
	
	
}

// End;