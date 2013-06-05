<?php

use Yeap\Controller;

Class Index extends Controller
{
	public function __construct()
	{
		
	}
	
	/**	
	 * 首页
	 */
	public function index()
	{
		$this->assign(array('content' => 'hello world!'));
	}
	
}