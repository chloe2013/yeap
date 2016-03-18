<?php

Class IndexController extends BaseController
{
	public function __construct()
	{

	}

	/**
	 * 淘宝api处理
	 * http://api.ta.amgbs.dev/token/fetchTbCode/TB02
	 * localhost/?code=ssssfff&state=VEIwMg==
	 * https://api.cn.amgbs.com/ta/token/tb/?code=2cnO8AekZljS2wWoKejDzXYC719847&state=VEIxMA%3D%3D
	 */
	public function index()
	{
		$data = $_GET;
		if(isset($data['state']) && isset($data['code']))
		{
			$shop = urlencode(base64_decode($data['state']));
			$code = $data['code'];
			$url = "http://api.ta.amgbs.dev/token/fetchToken/{$shop}/{$code}";
			header('Location: '.$url);
			exit;
		}
		$this->layout('blank');
		$this->assign('content',  'hello world!');
	}

}