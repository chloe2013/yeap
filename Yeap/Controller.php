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

abstract class Controller
{
	/**
	 * Set error handling and start session
	 */
	public function __construct()
	{
		
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
	 * Called after the controller method is run to send the response
	 */
	public function _send() {}
	
	/**
	 * layout
	 */
	public function _layout()
	{
		
	}
	
	/**
	 * 设置模板
	 */
	private function _setTemplate()
	{
		$this->tpl = new Template_();
		$this->tpl->template_dir = WEB_PATH;
		$this->tpl->compile_dir = CACHEPATH.'tpl_/_compile';
		$this->tpl->cache_dir = CACHEPATH.'tpl_/_cache';
	}
	
	/**
	 * view template
	 */
	public function _view()
	{
		
	}

}

// End
