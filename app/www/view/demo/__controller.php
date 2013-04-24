<?php

use Yeap\Controller;

Class Demo extends Controller
{
	public function __construct()
	{
		
	}
		
	public function index()
	{
		echo 'i am demo page';
	}
	
	public function sub()
	{
		echo 'i am demo sub page';
	}
	
}