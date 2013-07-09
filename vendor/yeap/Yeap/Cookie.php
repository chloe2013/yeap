<?php
namespace Yeap;

use Yeap\Request;
use Yeap\Config;
use Yeap\Security;

Class Cookie
{
	public static $settings = array();
	
	/**
	 * Decrypt and fetch cookie data
	 *
	 * @param string $name of cookie
	 * @param array $config settings
	 * @return mixed
	 */
	public static function get($name, $config = NULL)
	{
		// Use default config settings if needed
		$config = $config ?: static::$settings;

		if(isset($_COOKIE[$name]))
		{
			// Decrypt cookie using cookie key
			if($v = json_decode(Security::decrypt(base64_decode($_COOKIE[$name]), $config['key'])))
			{
				// Has the cookie expired?
				if($v[0] < $config['timeout'])
				{
					return is_scalar($v[1])?$v[1]:(array)$v[1];
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
	public static function set($name, $value = array(), $config = NULL)
	{
		// Use default config settings if needed
		extract($config ?: static::$settings);
		$value['last_update'] = time();
		// If the cookie is being removed we want it left blank
		$value = $value ? base64_encode(Security::encrypt(json_encode($value), Config::get('cookie_salt'))) : '';

		// Save cookie to user agent
		setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
	}
}