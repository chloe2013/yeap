<?php

Class DemoController extends BaseController
{
	public function __construct()
	{

	}

	public function index()
	{
		$this->layout('blank');
		$this->assign('test', 'hello world!');
	}

	public function sub()
	{
		$this->assign('test', ' i am demo sub page');
	}

	public function form()
	{
		$this->layout('blank');
		$this->assign('test', 'hello world!');
	}

}