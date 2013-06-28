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
		
	}
	
	/**
	 * get entity manager doctrine
	 * @return object
	 */
	public static function entity()
	{
		$cfg = new Config('database');
		$paths = array(
			APPPATH . '_Class/Entity',
		);
		$config = Setup::createAnnotationMetadataConfiguration($paths, $cfg->get('dev_mode'));
		$entity = EntityManager::create($cfg->get('database'), $config);
		return $entity;
	}
	
	
}