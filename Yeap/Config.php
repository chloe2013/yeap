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
		if(file_exists(WEBPATH . $config_file)) {
			include(WEBPATH . $config_file);
		} else if(file_exists(APPPATH . $config_file)) {
			include(APPPATH . $config_file);
		}
		
		// 把配置内容赋值给本类
		foreach($config as $k => $v)
		{
			$this->$k = $v;
		}
	}
	
	/**
	 * 获取配置项
	 */
	public function get($field)
	{
		return $this->$field;
	}
	
}
