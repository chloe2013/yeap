<?php

/**
 * base
 */
$config['domain']			= 'yeap.dev';

/**
 * crypt
 */
$config['crypt_salt']		= '%$67ffgg&87#$ff';
$config['crypt_length']		= 3;

/**
 * cookie
 */
$config['cookie'] = array();
$config['cookie']['expired']	= 24; // hours
$config['cookie']['domain']		= '.'.$config['domain'];
$config['cookie']['path']		= "/";
$config['cookie']['secure']		= FALSE;
$config['cookie']['httponly']	= FALSE;
$config['cookie_salt']			= "frjg&5fg*$@uti@j";
$config['cookie_prefix']		= "ye_"; // name 前缀