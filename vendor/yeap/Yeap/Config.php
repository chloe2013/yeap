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
	private static $setting = array(
		'domain' => '',
		'salt' => 'fu^&5fg$#ff', // 密码加密安全码
		'database' => array(), // 数据库配置信息
		'router' => array(), // 路由配置信息
		'defaultController' => 'Index',
	);

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
	 * get by key
	 */
	public function __get($key)
	{
		return self::get($key);
	}

	/**
	 * 加载配置文件
	 * 默认从web目录 加载 没有就加载通用的
	 */
	public function load($file)
	{
		$configFile = '/config/' . $file . EXT;

		foreach(array(PROJECTPATH, WEBPATH) as $path)
		{
			if(is_file($path . $configFile)) {
				foreach(include($path . $configFile) as $k => $v)
				{
					self::$setting[$k] = $v;
				}
			}
		}

		return $this;
	}

	/**
	 * get item
	 */
	public static function get($key)
	{
		if(isset(self::$setting[$key])) {
			return self::$setting[$key];
		}
		return NULL;
	}

	/**
	 * get all config items
	 * @return array
	 */
	public static function items()
	{
		return self::$setting;
	}

}

// End;