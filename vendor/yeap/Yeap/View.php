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
	const TPL_MODE = 'tpl';
	/**
	 * view template file
	 * @var string
	 */
	private $view = '';

	/**
	 * layout template file
	 * @var string
	 */
	private $layout = '';

	/**
	 * assign data for template
	 * @var array
	 */
	private $assign = array();

	/**
	 * tpl object
	 * @var object
	 */
	private $tpl = null;

	/**
	 * Returns a new view object for the given view.
	 *
	 * @param string $file the view file to load
	 * @param string $layout file
	 * @param array $data for assgin to template
	 */
	public function __construct($file, $layout = '', $data = array())
	{
		$this->view = $file;
		$this->assign = $data;
		$this->layout = $layout;

		$m = self::TPL_MODE.'Init';
		$this->$m();
	}

	private function tplInit()
	{
		$this->tpl = new Template();
		$this->tpl->template_dir = VIEWPATH;
		$this->tpl->compile_dir = CACHEPATH.'tpl_/_compile';
		$this->tpl->cache_dir = CACHEPATH.'tpl_/_cache';
	}

	/**
	 * use tpl
	 */
	private function tplPrint()
	{
		$this->tpl->define('view', $this->view . EXT);
		$this->tpl->define('layout', '_layout' . DS . $this->layout . EXT);
		$this->tpl->assign($this->assign);
		$this->tpl->assign('view', file_exists($this->view . EXT) ? $this->tpl->fetch('view') : '');
		print $this->tpl->fetch('layout');
	}

	/**
	private function rawInit()
	{
	}

	private function rawPrint()
	{
		include VIEWPATH.'_layout' . DS . $this->layout . EXT;
	}

	private function twigInit()
	{
		$loader = new \Twig_Loader_Filesystem(VIEWPATH);
		$this->tpl = new \Twig_Environment($loader, array(
		    'cache' => CACHEPATH.'twig_/_cache',
		));
	}

	private function twigPrint()
	{
		print $this->tpl->render($this->view . EXT, $this->assign);
	}
	**/

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
			$m = self::TPL_MODE.'Print';
			$this->$m();
			return ob_get_clean();
		}
		catch(Exception $e)
		{
			return 'error:' . $e->getMessage();
		}
	}

}

// END
