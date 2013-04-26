<?php
/**
 * Controller
 *
 * Basic outline for standard system controllers.
 *
 * @package		MicroMVC
 * @author		David Pennington
 * @copyright	(c) 2011 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Yeap;

use Yeap\View;

abstract class Controller
{
	
	private $view = '';
	private $layout = '';
	private $assign = array();
	
	/**
	 * Set error handling and start session
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * 在对象中调用一个不可访问方法时 都直接调用默认的方法
	 * @param $method 要调用的方法名称
	 * @param $args 枚举数组
	 */
	public function __call($method, $args)
	{
		array_unshift($args, $method);
		$this->view = str_replace($method, 'index', $this->view);
		if($args) {
			call_user_func_array(array($this, 'index'), $args);
		} else {
			$this->index($args);
		}
	}
	
	/**
	 * default index page
	 */
	public function index()
	{
		
	}

	/**
	 * Called before the controller method is run
	 *
	 * @param string $method name that will be run
	 */
	public function init($method) {}


	/* HTTP Request Methods
	abstract public function run();		// Default for all non-defined request methods
	abstract public function get();
	abstract public function post();
	abstract public function put();
	abstract public function delete();
	abstract public function options();
	abstract public function head();
	*/

	/**
	 * Called after the controller method is output the response
	 */
	public function _output()
	{
		echo new View($this->view, $this->layout, $this->assign);
	}
	
	/**
	 * 赋值
	 * @param array
	 */
	public function _assign($data = array())
	{
		$this->assign = $data;
	}
	
	/**
	 * set layout file
	 */
	public function _layout($file)
	{
		$this->layout = '_layout/' . $file . EXT;
	}
	
	/**
	 * set view file
	 */
	public function _view($file)
	{
		$this->view = $file;
	}
	
}

// End
