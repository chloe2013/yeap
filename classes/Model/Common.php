<?php
namespace Model;

Class Common {

	/**
	 * 简单的直接操作数据库
	 * @param string $table
	 * @return object
	 */
	public static function dao($d)
	{
		if(is_object($d)){return $d;}
		$c = "Dao\\{$d}";
		return new $c();
	}

}

// End;
