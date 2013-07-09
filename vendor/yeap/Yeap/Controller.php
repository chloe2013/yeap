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
use Yeap\Database;
use Yeap\ORM;
use Yeap\Request;

abstract class Controller
{
	/**
	 * view file
	 * @var string
	 */
	private $view = '';
	
	/**
	 * layout file
	 * @var string
	 */
	private $layout = '';
	
	/**
	 * assign data
	 * @var array
	 */
	private $assign = array();
	
	/**
	 * breadcrumb
	 * @var array
	 */
	private $breadcrumb = array();
	
	/**
	 * title for page
	 * @var string
	 */
	private $title = '';
	
	protected static $input = NULL;
	
	/**
	 * Set error handling and start session
	 */
	public function __construct()
	{
		self::$input = new Request;
	}
	
	/**
	 * default index method
	 */
	public function index()
	{
		
	}

	/**
	 * Called after the controller method is output the response
	 * 输出数据
	 */
	public function output()
	{
		// 直接输出	
		if($this->view && ! Request::isPost()) {
			$this->assign['title']	= $this->title;
			$this->assign['breadcrumb']	= $this->breadcrumb;
			echo new View($this->view, $this->layout, $this->assign);
		} // ajax 输出 json or html
		else if (Request::isAjax()) {
			if(isset($this->assign['json'])) {
				exit(json_encode($this->assign['json']));
			} else if(isset($this->assign['html']))	{
				exit($this->assign['html']);
			}
		} else {
			// exit;
		}
	}
	
	/**
	 * 赋值数组
	 * @param array
	 */
	final public function assign($data = array())
	{
		if($data) {
			$this->assign = array_merge($this->assign, $data);
		}	
	}
	
	/**
	 * set layout file
	 */
	final public function layout($file)
	{
		$this->layout = $file;
	}
	
	/**
	 * set view file
	 */
	final public function view($file)
	{
		$this->view = $file;
	}
	
	/**
	 * set breadcrumb
	 * @param string
	 */
	public function bread($str)
	{
		$this->breadcrumb[] = $str;
	}
	
	/**
	 * set title for every page
	 * @param string
	 */
	public function title($title)
	{
		$this->title = $title;
	}
	
	/**
	 * load a db
	 * @param string $name
	 */
	public function loadDb($name = '')
	{
		$db = new Database($name);
		ORM::db($db);
		return $db;
	}
	
}

// End
