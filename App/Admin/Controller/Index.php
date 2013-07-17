<?php
namespace Admin\Controller;

use Admin\Core\Controller;
use Model\Admin;

Class Index extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**	
	 * 首页
	 */
	public function index()
	{
		$this->title('test');	
		$this->assign('content', 'hello world!');
		
		$admin = new Admin();
		$lists = $admin->limit(10)->find();
	}
	
}

// End;