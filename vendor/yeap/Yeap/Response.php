<?php

namespace Yeap;

use Yeap\Request;
use Yeap\View;

Class Response {
	
	public function error($msg, $url = '/')
	{
		if(Request::isAjax()) {
			
		} else {
			$assign['msg'] = $msg;
			$assign['url'] = $msg;
			echo new View('system/error', 'blank', $assign);
		}
	}
	
	public function notFind()
	{
		
	}
}
