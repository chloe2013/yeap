<?php

use Yeap\Controller;

Class Demo extends Controller
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		$this->assign(array('test' => ' i am demo page'));
	}
	
	public function sub()
	{
		$this->assign(array('test' => ' i am demo sub page'));
	}
	
}