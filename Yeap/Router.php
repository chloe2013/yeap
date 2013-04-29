<?php 

namespace Yeap;

use Yeap\Config;

/**
 * 路由到控制器
 */
Class Router
{
	const CTL_NAME = '__controller';
	const DEFAULT_METHOD = 'index';
	
	/**
	 * 访问参数
	 * @var array
	 */
	private $param 	= array();
	
	/**
	 * 方法名
	 * @var string
	 */
	private $method = self::DEFAULT_METHOD;
	
	/**
	 * 控制器目录名 和 class 一致
	 * @var string
	 */
	private $controller = '';
	
	/**
	 * 控制器路径
	 * @var string
	 */
	private $path = '';
	
	private $config = NULL;
	
	/**	
	 * 构造函数
	 */
	public function __construct($path = '', Config $config)
	{
		$config->load('router');
		$this->config = $config;
		
		// set default path and controller
		$this->path = $config->default_controller . DS;
		$this->controller = $config->default_controller;
		
		// set controller and method
		if( !$path ) {
			$this->controller = $config->default_controller;
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
	 * load controller method
	 */
	public function load()
	{
		require_once(WEBPATH . $this->path . self::CTL_NAME . EXT);
		$controller = ucfirst($this->controller);
		$controller = new $controller($this->config);
		
		// 方法不存在时调用默认方法
		if(!method_exists($controller, $this->method)) {
			array_unshift($this->param, $this->method);
			$this->method = self::DEFAULT_METHOD;
		}
		
		// 设置视图文件
		$controller->view($this->path . $this->method);
		
		// 设置模版里用到的参数
		$controller->assign(array('config' => $this->config->items()));
		$controller->assign(array('url' => $this->path . $this->controller . $this->method));
		
		// 设置模版文件
		$controller->layout('default');
		
		// 调用controller 方法
		if($this->param) {
			call_user_func_array(array($controller, $this->method), $this->param);
		} else {
			$controller->{$this->method}();
		}
		
		// 视图输出
		$controller->output();
	}
}

// End;