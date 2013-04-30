<?php

use Yeap\Controller;

Class Index extends Controller
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		$this->layout('blank');	
		$this->assign(array('content' => 'hello world!'));
	}
}