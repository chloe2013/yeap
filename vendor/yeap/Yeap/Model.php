<?php 

namespace Yeap;

use Yeap\Config;
use Yeap\ORM;

abstract Class Model extends ORM
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
}