<?php

use Framework\Registry;

use Framework\Configuration;

use Framework\Configuration\Driver\Ini;

use Framework\Inspector;

use Framework\StringMethods;

use Framework\Base;

try {
	
	// Autoloader
	require "Core/Autoload.php";
	spl_autoload_register(array('autoloader', 'autoload'));
	
	$c = new Hello();
	Registry::set('db', $c);
	var_dump(Registry::getListe());
	
	
} catch (Exception $e) {
	echo $e->getMessage();
}

