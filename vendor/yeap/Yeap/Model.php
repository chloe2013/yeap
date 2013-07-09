<?php 

namespace Yeap;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Yeap\Config;
use Yeap\ORM;

abstract Class Model extends ORM
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * get entity manager doctrine
	 * @return object
	 */
	public static function entity()
	{
		$paths = array(
			APPPATH . '_Class/Entity',
		);
		$config = Setup::createAnnotationMetadataConfiguration($paths, Config::get('dev_mode'));
		$entity = EntityManager::create(Config::get('database'), $config);
		return $entity;
	}
	
	
}