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
	private $database 	= array();
	private $active_db 	= 'master';
	private $domain 	= '';
	private $router 	= array();
	
	/**
	 * 构造函数
	 * @param string config file_name
	 */
	public function __construct($file_name = '')
	{
		if($file_name) {
			$this->load($file_name);
		}
	}
	
	/**
	 * 加载配置文件
	 * 默认从web目录 加载 没有就加载通用的
	 */
	public function load($file_name = '')
	{
		$config = array();
		$config_file = 	'/_config/' . $file_name . EXT;
		
		// load app config
		if(is_file(APPPATH . $config_file)) {
			require(APPPATH . $config_file);
		}
		
		// load web config
		if(is_file(WEBPATH . $config_file)) {
			require(WEBPATH . $config_file);
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
		if(property_exists($this, (string)$field)) {
			return $this->$field;
		}	
		return NULL;
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