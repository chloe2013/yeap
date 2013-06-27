<?php

use Yeap\Controller;
use Model\User;

Class Demo extends Controller
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		$user = new User();
		$user->add();
		
		$this->assign(array('test' => ' i am demo page'));
	}
	
	public function sub()
	{
		$this->assign(array('test' => ' i am demo sub page'));
	}
	
}