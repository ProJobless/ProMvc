<?php

use Framework\Inspector;

use Framework\StringMethods;

use Framework\Base;

try {
	
	// Autoloader
	require "Core/Autoload.php";
	spl_autoload_register(array('autoloader', 'autoload'));
	
	//var_dump(StringMethods::match("contrl/action/param/divers", "/"));
	
	
	$hello = new Hello();
	echo $hello->world;
	
	
} catch (Exception $e) {
	echo $e->getMessage();
}

