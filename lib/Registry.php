<?php

class Registry
{
	private static $_instance;
	
	protected $_data = array();
	
	public static function getInstance()
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	public function set($key, $value)
	{
		$this->_data[$key] = $value;
	}
	
	public function get($key, $default = null) 
	{
		if ( ! array_key_exists($key, $this->_data)) {
			return $default;
		}
		
		return $this->_data[$key];
	}
}