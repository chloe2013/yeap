<?php 

namespace Yeap;

use tpl\Template;

Class Template extends Template_
{
	private $tpl = null;	
	public function __construct()
	{
		$this->tpl = new Template_();
		$this->tpl->template_dir = WWWPATH;
		$this->tpl->compile_dir = CACHEPATH.'tpl_/_compile';
		$this->tpl->cache_dir = CACHEPATH.'tpl_/_cache';
			
		$this->tpl->assign('config', $this->config->config);
		$this->tpl->assign('uri_string', $this->uri->uri_string);
		$this->tpl->assign('session', $this->session->userdata);
	}
	
	public function output()
	{
		
	}
}