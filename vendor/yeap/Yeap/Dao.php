<?php

namespace Yeap;

use Yeap\Config;
use Yeap\ORM;

abstract Class Dao extends ORM
{

	public function __construct()
	{
		parent::__construct();
	}

}