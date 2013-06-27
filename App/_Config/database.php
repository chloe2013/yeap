<?php

/**
 * database config mysql
 * driver:pdo_mysql/pdo_sqlite/pdo_pgsql
 * @see http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html
 */
$config['database'] = array(
	'wrapperClass'	=> 'Doctrine\DBAL\Connections\MasterSlaveConnection',
	'driver' => 'pdo_mysql',
	'master' => array(
		'host' => '127.0.0.1',
		'port' => '3306',
		'dbname' => 'cake',
		'user' => 'root',
		'password' => '123456',
		'charset' => 'utf8',
	),
	'slaves' => array(
		array(
			'host' => '127.0.0.1',
			'port' => '3306',
			'dbname' => 'cake',
			'user' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
		)
	)
);
$config['active_db'] = 'master';
$config['dev_mode'] = false;
$config['mapping_path'] = '_Data/mapping';
