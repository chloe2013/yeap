<?php 

namespace Yeap;
use Yeap\Config;

Class Security
{
	public function __construct()
	{
		
	}
	
	/**
	 * xss filter
	 * @param mixed string or array
	 */
	public static function xssFilter($str)
	{
		
	}
	
	/**
	 * post or get key filter
	 * @param string $key
	 * @return string
	 */
	public static function keyFilter($key)
	{
		if ( ! preg_match("/^[a-z0-9:_\/-]+$/i", $key))
		{
			return '';
		}
		return $key;
	}
	
	/**
	 * post or get value filter
	 * @param mixed array or string $value
	 * @return mixed
	 */
	public static function valueFilter($values)
	{
		if(is_array($values))
		{
			$arr = array();
			foreach($values as $key => $val)
			{
				$arr[self::keyFilter($key)] = self::valueFilter($val);
			}
			return $arr;
		}
		return $values;
	}
	
	/**
	 * is ascii
	 */
	public static function isAscii($str)
	{
		return (preg_match('/[^\x00-\x7F]/S', $str) == 0);
	}
	
	/**
	 * 密码设置
	 */
	public static function password($pwd)
	{
		return md5(crypt($pwd, substr($pwd, 0, 3)). Config::get('salt'));
	}
	
	/**
	 * Encrypt a string
	 *
	 * @param string $text to encrypt
	 * @param string $key a cryptographically random string
	 * @param int $algo the encryption algorithm
	 * @param int $mode the block cipher mode
	 * @return string
	 */
	public static function encrypt($text, $key, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
	{
		// Create IV for encryption
		$iv = mcrypt_create_iv(mcrypt_get_iv_size($algo, $mode), MCRYPT_RAND);

		// Encrypt text and append IV so it can be decrypted later
		$text = mcrypt_encrypt($algo, hash('sha256', $key, TRUE), $text, $mode, $iv) . $iv;

		// Prefix text with HMAC so that IV cannot be changed
		return hash('sha256', $key . $text) . $text;
	}


	/**
	 * Decrypt an encrypted string
	 *
	 * @param string $text to encrypt
	 * @param string $key a cryptographically random string
	 * @param int $algo the encryption algorithm
	 * @param int $mode the block cipher mode
	 * @return string
	 */
	public static function decrypt($text, $key, $algo = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
	{
		$hash = substr($text, 0, 64);
		$text = substr($text, 64);

		// Invalid HMAC?
		if(hash('sha256', $key . $text) != $hash) return;

		// Get IV off end of encrypted string
		$iv = substr($text, -mcrypt_get_iv_size($algo, $mode));

		// Decrypt string using IV and remove trailing \x0 padding added by mcrypt
		return rtrim(mcrypt_decrypt($algo, hash('sha256', $key, TRUE), substr($text, 0, -strlen($iv)), $mode, $iv), "\x0");
	}
	
}

// End;