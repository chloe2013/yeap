<?php 

namespace Yeap;

use Yeap\Config;
use \BadMethodCallException;

Class Router
{
	const CTL_NAME = '__controller';
	const DEFAULT_METHOD = 'index';	
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
			$this->method = self::DEFAULT_METHOD;
		} else {
			$path = strtolower(trim(urldecode($path), DS));
			$paths = array_filter(explode(DS, $path), 'strlen');
			$len = count($paths);
			// 倒序循环路径
			for($i = $len - 1; $i >= 0; $i--) {
				$tmp = implode(DS, array_slice($paths, 0, $i + 1)) . DS;
				if($paths && is_file(WEBPATH . $tmp . self::CTL_NAME . EXT)) {
					$this->controller = $paths[$i];
					$this->method = isset($paths[$i+1]) ? $paths[$i+1] : self::DEFAULT_METHOD;
					$this->path = $tmp;
					$this->param = array_slice($paths, $i + 2);
					break;
				}
			}
		}
	}
	
	/**
	 * load controller
	 * @throw BadMethodCallException
	 */
	public function load()
	{
		require_once(WEBPATH . $this->path . self::CTL_NAME . EXT);
		$controller = ucfirst($this->controller);
		$controller = new $controller();
		if( method_exists($controller, $this->method) ){
			
		}
		else if( method_exists($class, self::DEFAULT_METHOD)) {
			array_unshift($this->param, $this->method);
			$this->method = self::DEFAULT_METHOD;
		}
		else {
			throw new BadMethodCallException('error method');
		}
		if($this->param) {
			call_user_func_array(array($controller, $this->method), $this->param);
		} else {
			$controller->{$this->method}();
		}
		return $controller;
	}
}