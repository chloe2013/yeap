<?php

use Model\User;

Class DemoController extends BaseController
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		$user = new User();
		$user->add();
		
		$this->assign('test', ' i am demo page');
	}
	
	public function sub()
	{
		$this->assign('test', ' i am demo sub page');
	}
	
}