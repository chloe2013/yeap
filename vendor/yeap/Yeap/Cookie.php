<?php
namespace Yeap;

use Yeap\Request;
use Yeap\Config;
use Yeap\Security;

Class Cookie
{
	private static $settings = array();
	
	/**
	 * set default setting
	 */
	public static function init($config = array())
	{
		if(!self::$settings)
		{
			self::$settings = Config::get('cookie');
		}
		return $config ? array_merge(self::$settings, $config) : self::$settings;
	}
	
	/**
	 * Decrypt and fetch cookie data
	 *
	 * @param string $name of cookie
	 * @param array $config settings
	 * @return mixed
	 */
	public static function get($name, $config = array())
	{
		$config = self::init($config);	
		$name = Config::get('cookie_prefix').$name;
		if(isset($_COOKIE[$name]))
		{
			// Decrypt cookie using cookie key
			if($v = json_decode(Security::decrypt(base64_decode($_COOKIE[$name]), Config::get('cookie_salt')), TRUE))
			{
				// Has the cookie expired?
				if((time() - $v['last_update']) < $config['expired'] * 3600)
				{
					return is_scalar($v) ? $v : (array)$v;
				}
			}
		}

		return FALSE;
	}


	/**
	 * Called before any output is sent to create an encrypted cookie with the given value.
	 *
	 * @param string $key cookie name
	 * @param mixed $value to save
	 * @param array $config settings
	 * return boolean
	 */
	public static function set($name, $value = array(), $config = array())
	{
		$config = self::init($config);	
		extract($config);
		$value['last_update'] = time();
		$name = Config::get('cookie_prefix').$name;
		// If the cookie is being removed we want it left blank
		$value = $value ? base64_encode(Security::encrypt(json_encode($value), Config::get('cookie_salt'))) : '';
		// Save cookie to user agent
		setcookie($name, $value, time() + $expired * 3600, $path, $domain, $secure, $httponly);
	}
}