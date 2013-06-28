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
		$this->assign(array('content' => 'hello world!'));
		
		$admin = new Admin();
		$lists = $admin->limit(10)->find();
		//var_dump($lists);die;
		
		$admin->id = 5;
		$admin->uid = 'test';
		$admin->name = 'test2';
		$admin->password = md5('123456');
		$admin->role_id = 4;
		$admin->created = time();
		$admin->save();
	}
	
}