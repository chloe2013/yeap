<?php

/**
 * database config mysql
 * pg example:
 * //'dns' => "pgsql:host=localhost;port=5432;dbname=test",
 * //'username' => 'postgres',
 * //'password' => 'postgres',
 */
$config['database'] = array(
	'master' => array(
		'dns' => "mysql:host=127.0.0.1;port=3306;dbname=test",
		'username' => 'root',
		'password' => '123456',
		'params' => array()
	)
);
$config['active_db'] = 'master';
