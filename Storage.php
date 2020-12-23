<?php 

class Storage{
	
	private static $cache;
	private static $prefix = 'project:'; // Example: users-> project:users
	
	public function __clone() {}
	public function __wakeup() {}
	public function __construct() {}

	/**
	 *@return Memcached
	 */	
	private static function getInstance() {
		if (!static::$cache){
			$m = new Memcached();
			$m ->addServer('127.0.0.1', '11211');
			static::$cache = $m;
		}
		
		return static::$cache;
	}
 	
	public static function set($key, $value) {
		try{			
			return static::getInstance()->set(static::$prefix . $key, $value);
		}catch (Exception $error) {
			echo $error->getMessage();
		}
	}
	
	public static function delete($key) {
		try{			
			return static::getInstance()->delete(static::$prefix . $key);
		}catch (Exception $error) {
			echo $error->getMessage();
		}
	}
	
	public static function get($key) {
		try{			
			return static::getInstance()->get(static::$prefix . $key);
		}catch (Exception $error) {
			echo $error->getMessage();
		}
	}
	
}