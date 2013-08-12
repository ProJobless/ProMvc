<?php

use Framework\Router\Route\Simple;

use Framework\Router;

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
	
	$router = new Router();
	$router->addRoute(new Simple(array(
			"pattern" => ":name/profile",
			"controller" => "home",
			"action" => "index"
			)));
	$router->url = "bader/profile";
	$router->dispatch();
	
	
} catch (Exception $e) {
	echo $e->getMessage();
}

