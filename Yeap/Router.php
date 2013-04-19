<?php 

namespace Yeap;

use Yeap\Config;

Class Router
{
	private $param = array();
	private $method = 'index';
	private $controller = 'index';
	private $path = '';
	
	/**	
	 * 
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
			$dirs = explode(DS, $path);
			// 循环路径
			$tmp = 'controller';
			foreach($dirs as $k => $v) {
				$tmp .= $v . DS;
				$controller = $dirs[$k];
				$method = isset($dirs[$k+1]) ? $dirs[$k+1] : $config->default_method;
				// check file
				if( $controller && is_file(WEBPATH . DS . $tmp . $controller . EXT) ) {
					$this->controller = $controller;
					$this->method = $method;
					$this->param = array_slice($paths, $k+1);
					$this->path = $tmp;
					break;
				} else if ( $method && is_file(WEBPATH . DS . $tmp . $method . EXT) ) {
					$this->controller = $method;
					$this->param = array_slice($paths, $k+1);
					$this->path = $tmp;
					break;
				}
			}
		}
	}
	
	/**
	 * load controller
	 */
	public function load()
	{
		require_once(WEBPATH . DS . $this->path . $this->controller . EXT);
		$class = ucfirst($this->controller);
		$class = new $class();
		if( method_exists($class, $this->method) ) {
			call_user_func_array(array($class, $this->method), $this->param);
		}
		else{
			throw new BadMethodCallException('bad method');
		}
	}
}