<?php
namespace Admin\Controller;

use Admin\Core\Controller;
use Model\User;

Class Index extends Controller
{
	public function __construct()
	{
		
	}
	
	/**	
	 * 首页
	 */
	public function index()
	{
		$this->title('test');	
		$this->assign(array('content' => 'hello world!'));
		
		$user = new User();
		$user->add();
	}
	
}