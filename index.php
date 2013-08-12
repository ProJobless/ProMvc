<?php

use Framework\Configuration;

use Framework\Configuration\Driver\Ini;

use Framework\Inspector;

use Framework\StringMethods;

use Framework\Base;

try {
	
	// Autoloader
	require "Core/Autoload.php";
	spl_autoload_register(array('autoloader', 'autoload'));
	
	// Configuration
	$config = new Configuration(array("type"=>"ini"));
	$config = $config->initialize()->parse("config");
	var_dump($config);
	
	
} catch (Exception $e) {
	echo $e->getMessage();
}

