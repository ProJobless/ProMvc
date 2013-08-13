<?php

namespace Framework;

class Core {
	
	public static function initialize()
	{
		spl_autoload_register(array(__NAMESPACE__ . "\\Autoloader", 'autoload'));
	}
}

class Autoloader {

	public static function autoload($class)
	{
		self::_autoload($class);
	}

	public static function _autoload($class)
	{

		$file = strtolower(str_replace("\\", DIRECTORY_SEPARATOR, trim($class, "\\"))).".php";
		$combined = APP_PATH . DIRECTORY_SEPARATOR . $file;
		
		if (file_exists($combined))
		{
			include($combined);
			return;
		}

		throw new \Exception("{$class} not found");
	}
}
