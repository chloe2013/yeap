<?php 

namespace Yeap;

use Yeap\Security;

Class Request
{
	const METHOD_HEAD = 'HEAD';
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_OVERRIDE = '_METHOD';
		
	public function __construct()
	{
		
	}
	
	/**
	 * server data
	 */
	public static function server($key = NULL, $xss = FALSE)
	{
		return self::getValue($_SERVER, $key, $xss);
	}
	
	/**
	 * filter post data
	 */
	public static function post($key = NULL, $xss = FALSE)
	{
		return self::input($_POST, $key, $xss);
	}
	
	/**
	 * filter get data
	 */
	public static function get($key = NULL, $xss = FALSE)
	{
		return self::input($_GET, $key, $xss);
	}
	
	/**
	 * filter get data
	 */
	public static function cookie($key = NULL, $xss = FALSE)
	{
		return self::getValue($_COOKIE, $key, $xss);
	}
	
	/**
	 * filter input data
	 */
	private static function input(&$array, $key, $xss)
	{
		// Check if a field has been provided
		if ($key === NULL AND ! empty($array))
		{
			$data = array();

			// loop through the full array
			foreach (array_keys($array) as $key)
			{
				if($key = Security::keyFilter($key)){
					$data[$key] = self::getValue($array, $key, $xss);
				}
			}
			return $data;
		}

		return self::getValue($array, $key, $xss);
	}
	
	/**
	 * filter value and key
	 */
	private static function getValue(&$array, $key = '', $xss = FALSE)
	{
		if ( ! isset($array[$key]))
		{
			return FALSE;
		}

		if ($xss === TRUE)
		{
			return Security::xssFilter($array[$key]);
		}

		return Security::valueFilter($array[$key]);
	}
	
	/**
	 * 获取方法
	 * @return string
	 */
	public static function method()
	{
		return self::server('REQUEST_METHOD');
	}
	
	/**
     * Is this a GET request?
     * @return bool
     */
    public static function isGet()
    {
        return self::method() === self::METHOD_GET;
    }

    /**
     * Is this a POST request?
     * @return bool
     */
    public static function isPost()
    {
        return self::method() === self::METHOD_POST;
    }

    /**
     * Is this a PUT request?
     * @return bool
     */
    public static function isPut()
    {
        return self::method() === self::METHOD_PUT;
    }

    /**
     * Is this a DELETE request?
     * @return bool
     */
    public static function isDelete()
    {
        return self::method() === self::METHOD_DELETE;
    }

    /**
     * Is this a HEAD request?
     * @return bool
     */
    public static function isHead()
    {
        return self::method() === self::METHOD_HEAD;
    }

    /**
     * Is this a OPTIONS request?
     * @return bool
     */
    public static function isOptions()
    {
        return self::method() === self::METHOD_OPTIONS;
    }

    /**
     * Is this an AJAX request?
     * @return bool
     */
    public static function isAjax()
    {
        return self::server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
    }
	
	/**
	 * is cli
	 */
	public static function isCli()
	{
		
	}
	
	/**
	 * get url path
	 */
	public static function getUrl()
	{
		return parse_url(self::server('REQUEST_URI'), PHP_URL_PATH);
	}
	
	
}