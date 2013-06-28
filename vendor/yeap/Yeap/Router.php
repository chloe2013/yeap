<?php 

namespace Yeap;

use Yeap\Config;

/**
 * 路由到控制器
 */
Class Router
{
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
		$this->path = DS;
		$this->controller = $config->get('defaultController');
		
		// set controller and method
		if($path) {
			$path = strtolower(trim(urldecode($path), DS));
			$paths = array_filter(explode(DS, $path), 'strlen');
			$paths = array_map('ucfirst', $paths);
			$len = count($paths);
			// 倒序循环路径
			for($i = $len - 1; $i >= 0; $i--) {
				$tmp = implode(DS, array_slice($paths, 0, $i)) . DS;
				$controller = $paths[$i];
				if($paths && is_file(CTLPATH . $tmp . $controller . EXT)) {
					if(isset($paths[$i+1]))
					{
						$this->method = $paths[$i+1];
						$this->param = array_slice($paths, $i + 2);
					} else {
						$this->param = array_slice($paths, $i + 1);
					}
					$this->path = $tmp;
					$this->controller = $controller;
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
		//require_once(CTLPATH . $this->path . $this->controller . EXT);
		$path = str_replace('/', '\\', $this->path);
		$controller = DOMAIN.'\\Controller'.$path.$this->controller;
		$controller = new $controller($this->config);
		
		// 反射类
		//$rc = new ReflectionClass('\\'.DOMAIN.'\\Controller'.$path.$this->controller);
		//$controller = $rc->newInstance($this->config);
		
		// 方法不存在时调用默认方法
		if($this->method != self::DEFAULT_METHOD 
			&& !method_exists($controller, $this->method)) {
			array_unshift($this->param, $this->method);
			$this->method = self::DEFAULT_METHOD;
		}
		// url
		$path = strtolower($this->path . $this->controller . DS . $this->method);
		
		// 设置视图文件
		$controller->view(rtrim($path, DS));
		
		// 设置模版里可能用到的参数
		$controller->assign(array('config' => $this->config->items()));
		$controller->assign(array('url' => $path));
		
		
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