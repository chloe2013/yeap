<?php 
/**
 * 
 */
namespace Yeap;

Class Config
{
	/**	
	 * 初始化一些配置项
	 */
	private $database = array();
	private $domain = '';
	private $router = array();
	private $defaultController = 'Index';
	
	/**
	 * 构造函数
	 * @param string config file_name
	 */
	public function __construct($file = '')
	{
		if($file) {
			$this->load($file);
		}
	}
	
	/**
	 * 加载配置文件
	 * 默认从web目录 加载 没有就加载通用的
	 */
	public function load($file = '')
	{
		$config = array();
		$configFile = 	'/_Config/' . $file . EXT;
		
		// load app config
		if(is_file(APPPATH . $configFile)) {
			include(APPPATH . $configFile);
		}
		
		// load web config
		if(is_file(WEBPATH . $configFile)) {
			include(WEBPATH . $configFile);
		}
		
		// 把配置内容赋值给本类
		foreach($config as $k => $v)
		{
			$this->$k = $v;
		}
	}
	
	/**
	 * 获取配置项
	 * @param string $field
	 */
	public function get($field)
	{
		return $this->$field;
	}
	
	/**
	 * get all config items
	 * @return array
	 */
	public function items()
	{
		return get_object_vars($this);
	}
	
}

// End;