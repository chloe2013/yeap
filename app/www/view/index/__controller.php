<?php

use Yeap\Controller;

Class Index extends Controller
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		echo 'i am index page';
	}
	
	public function hello()
	{
		echo 'hello world';
	}
}