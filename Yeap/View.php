<?php
/**
 * View
 *
 * Provides fetching of HTML template files
 *
 * @package		MicroMVC
 * @author		http://github.com/tweetmvc/tweetmvc-app
 * @copyright	(c) 2011 MicroMVC Framework
 * @license		http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Yeap;

use Tpl\Template;
use \Exception;

class View
{

	private $_view = '';
	private $_layout = '';
	private $_assign = array();
	private $tpl;

	/**
	 * Returns a new view object for the given view.
	 *
	 * @param string $file the view file to load
	 * @param string $layout file
	 * @param array $data for assgin to template
	 */
	public function __construct($file, $layout = '', $data = array())
	{
		$this->_view = $file;
		$this->_assign = $data;
		$this->_layout = $layout;
		
		$this->tpl = new Template();
		$this->tpl->template_dir = WEBPATH;
		$this->tpl->compile_dir = CACHEPATH.'tpl_/_compile';
		$this->tpl->cache_dir = CACHEPATH.'tpl_/_cache';
	}
	
	/**
	 * 设置模板
	 */
	private function _print()
	{
		$this->tpl->define('view', $this->_view . EXT);
		$this->tpl->define('layout', $this->_layout);
		$this->tpl->assign($this->_assign);
		$this->tpl->assign('view', $this->tpl->fetch('view'));
		print $this->tpl->fetch('layout');
	}

	/**
	 * Return the view's HTML 不能抛出异常
	 *
	 * @return string
	 */
	public function __toString()
	{
		try {
			ob_start();
			extract((array) $this);
			$this->_print();
			return ob_get_clean();
		}
		catch(Exception $e)
		{
			return 'error:' . $e->getMessage();
		}
	}
	
}

// END
