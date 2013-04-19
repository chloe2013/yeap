<?php 

namespace Yeap;

use Yeap\Config;
use \BadMethodCallException;

Class Router
{
	const CTL_NAME = '__controller';	
	private $param = array();
	private $method = 'index';
	private $controller = 'index';
	private $path = 'index/';
	
	/**	
	 * 构造函数
	 */
	public function __construct($path = '', Config $config)
	{
		$config->load('router');
		
		// set controller and method
		if( !$path ) {
			$this->controller = $config->default_controller;
			$this->method = $config->default_method;
		} else {
			$path = strtolower(trim(urldecode($path), DS));
			$paths = explode(DS, $path);
			var_dump($paths);
			for($i = count($paths) - 1; $i >= 0; $i--) {
				
			}
			// 循环路径
			$tmp = '';
			while($tmp_dirs)
			{
				$this->path = implode(DS, $tmp_dirs) . DS;
				$this->controller = array_pop($tmp_dirs);
				$this->method = '';
				var_dump(WEBPATH . $this->path . self::CTL_NAME . EXT);
				if(is_file(WEBPATH . $this->path . self::CTL_NAME . EXT)) {
					break;
				}
			}
			var_dump($this->controller);die;
		}
	}
	
	/**
	 * load controller
	 */
	public function load()
	{
		var_dump(WEBPATH . $this->path . self::CTL_NAME . EXT);die;	
		require_once(WEBPATH . $this->path . self::CTL_NAME . EXT);
		
		$class = ucfirst($this->controller);
		$class = new $class();
		if( method_exists($class, $this->method) ) {
			call_user_func_array(array($class, $this->method), $this->param);
		} else {
			throw new BadMethodCallException('bad method');
		}
	}
}