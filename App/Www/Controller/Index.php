<?php
namespace Www\Controller;

use Yeap\Controller;

Class Index extends Controller
{
	public function __construct()
	{
		
	}
	
	/**	
	 * 淘宝api处理
	 * http://api.ta.amgbs.dev/token/fetchTbCode/TB02
	 * localhost/?code=ssssfff&state=VEIwMg==
	 */
	public function index()
	{
		$data = $_GET;
		if(isset($data['state']) && isset($data['code']))
		{
			$shop = urlencode(base64_decode($data['state']));
			$code = $data['code'];
			$url = "http://api.ta.amgbs.dev/token/fetchTbToken/{$shop}/{$code}";
			header('Location: '.$url);
			exit;
		}
		$this->layout('blank');
		$this->assign(array('content' => 'hello world!'));
	}
	
}