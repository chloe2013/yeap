<?php
namespace Admin\Core;

use Yeap\Controller AS BaseController;
use Model\Auth;
use Model\Admin;
use Yeap\Request;

Class Controller extends BaseController
{
	public function __construct()
	{
		parent::__construct();
		
		// 连接数据库
		$this->loadDb();
		
		// 后台登录权限设置
		
		// 后台菜单设置
		
		// 后台用户登录信息设置
		$this->checkLogin();
	}
	
	/**
	 * 登录检查
	 */
	private function checkLogin()
	{
		$admin = new Admin();
		if($login = $admin->isLogin()) {
			$this->assign('login', $login);
		} else if(strpos(Request::getUrl(), '/login') === FALSE) {
			$this->jump('/login');
		}
	}
	
}

// End;