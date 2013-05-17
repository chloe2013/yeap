<?php 

namespace Yeap;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Yeap\Config;
use Yeap\Database;

abstract Class Model
{
	/**
	 * 实体管理器
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected static $em;
		
	public function __construct()
	{
		if(null === self::$em)
		{
			self::$em = self::getEntityManager();
		}
	}
	
	/**
	 * get entity manager
	 * @return object
	 */
	public static function getEntityManager()
	{
		$cfg = new Config('database');
		$paths = array(
			APPPATH . '_class/Entity',
		);
		$config = Setup::createAnnotationMetadataConfiguration($paths, $cfg->get('dev_mode'));
		$entityManager = EntityManager::create($cfg->get('database'), $config);
		return $entityManager;
	}
	
	/**
	 * 原生方式加载pdo
	 * @return object
	 */
	public function getRaw()
	{
		$db = new Database();
		$db->connect();
		return $db;
	}
}