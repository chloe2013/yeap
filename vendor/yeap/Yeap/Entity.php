<?php

namespace Yeap;

abstract class Entity implements \ArrayAccess
{
	function __construct()
	{
	}
	
	/**
	 * 
	 */
	public function __call($method, $args)
	{
		
	}

	//--------------------------------------------------------------------------------------------//
	//	functions to implemet for ArrayAccess
	//--------------------------------------------------------------------------------------------//
	public final function offsetSet($offset, $value)
	{
		$this->{$offset} = $value;
	}
	public final function offsetExists($offset) 
	{
		return isset($this->{$offset});
	}
	public final function offsetUnset($offset) 
	{
		unset($this->{$offset});
	}
	public final function offsetGet($offset) 
	{
		return isset($this->{$offset}) ? $this->{$offset} : null;
	}
	//--------------------------------------------------------------------------------------------//
	
	/**
	 * init data
	 */
	public function init($data)
	{
		if(empty($data)) { return; }
		foreach($data as $k => $v)
		{
			if(property_exists($this, $k))
			{
				$this->{$k} = $v;
			}
		}
	}
}