<?php
	session_start();

	abstract class Base{
		private static $classes = array();

		public static function get($class, $params = array(), $forceNew = false, $path = null, $file = null){
			//Default files
			if($class == 'PageManager' && $path === null) $path = 'base/';
			else if($class == 'Database' && $path === null) $path = 'base/';
			else if($class == 'Layout' && $path === null) $path = 'base/';
			else if($class == 'Queries' && $path === null) $path = 'base/';
			else if($class == 'QueryManager' && $path === null) $path = 'base/';
			//Default values
			if($path === null) $path = 'class/';
			if($file === null) $file = strtolower($class). '.php';
			//Include if not excists
			if(!isset(self::$classes[$path . $file]) || $forceNew){
				//Include file
				if(file_exists(self::getBaseURL() . $path . $file)) include_once(self::getBaseURL() . $path . $file);
				else{
					echo 'Fatal &#39;Base&#39; error: Class &#39;<b>' .$class. '&#39;</b> not found. Path: <b>' .$path . $file. '</b>.';
					Base::get('PageManager')->close();
				}
				//Single parameter
				if(!is_array($params)) $params = array($params);
				//Open class
				$reflectionClass = new ReflectionClass($class);
				if($forceNew) return $reflectionClass->newInstanceArgs($params);
				else self::$classes[$path . $file] = $reflectionClass->newInstanceArgs($params);
			}
			//Return class
			return self::$classes[$path . $file];
		}
		public static function getAll(){
			return self::$classes;
		}
		public static function getBaseURL(){
			return realpath(dirname(__FILE__)). '/../';
		}
	}

	function dump($val){
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}
?>