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
	private $layout = 'default';
	
	/**
	 * assign data
	 * @var array
	 */
	protected $assign = array();
	
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
	
	/**
	 * output type view/json/html
	 */
	protected $out_type = 'view';
	
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
	final public function output()
	{
		// 直接输出	
		if($this->out_type == 'view' && $this->view) {
			$this->assign['title']	= $this->title;
			$this->assign['breadcrumb']	= $this->breadcrumb;
			echo new View($this->view, $this->layout, $this->assign);
		} // ajax 输出 json
		else if ($this->out_type == 'json' && isset($this->assign['json'])) {
			exit(json_encode($this->assign['json']));
		} // ajax 输出 html/text
		else if(isset($this->assign[$this->out_type])) {
			exit($this->assign[$this->out_type]);
		} else {
			// exit;
		}
	}
	
	/**
	 * 赋值数组
	 * @param string $key
	 * @param string $value
	 */
	final public function assign($key, $value)
	{
		$this->assign[$key] = $value;
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
		if($file) {
			$this->out_type = 'view';
		}
	}
	
	/**
	 * set breadcrumb
	 * @param string
	 */
	protected function bread($str, $url)
	{
		$this->breadcrumb[] = array('title' => $str, 'url' => $url);
	}
	
	/**
	 * set title for every page
	 * @param string
	 */
	protected function title($title)
	{
		$this->title = $title;
	}
	
	/**
	 * set output type for output
	 */
	protected function outJson()
	{
		$this->out_type = 'json';
	}
	
	/**
	 * before method
	 */
	protected function before()
	{
		if(Request::isPost()) {
			$this->out_type = 'none';
		}
		if(Request::isAjax()) {
			$this->out_type = 'json';
		}
	}
	
	/**
	 * 页面跳转
	 */
	protected function jump($url)
	{
		if(strpos($url, 'http') !== 0)
		{
			$url = 'http://'.Config::get('base_domain').DS.trim($url, DS);
		}
		if(!headers_sent()) {
			header("Location: {$url}");
		} else { // If headers are sent... do java redirect... if java disabled, do html redirect.
	        echo '<script type="text/javascript">';
	        echo 'window.location.href="'.$url.'";';
	        echo '</script>';
	        echo '<noscript>';
	        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
	        echo '</noscript>';
    	}
		exit;
	}
	
	/**
	 * load a db
	 * @param string $name
	 */
	protected function loadDb($name = '')
	{
		$db = new Database($name);
		ORM::db($db);
		return $db;
	}
	
}

// End
