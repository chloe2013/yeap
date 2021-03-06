<?php

use Model\Admin;

Class LoginController extends BaseController
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**	
	 * 登陆页面
	 */
	public function index()
	{
		if(parent::$input->isPost())	
		{
			$admin = new Admin();
			$admin->login(parent::$input->post('uid'), parent::$input->post('password'));
			$this->jump('/');
		}
		$this->title('登录');
		$this->layout('login');
	}
	
	/**
	 * logOut
	 */
	public function out()
	{
		$admin = new Admin();
		$admin->logout();
		$this->jump('/login');
	}
}

// End;