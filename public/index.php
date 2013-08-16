<?php

// 1. define the default path for includes
define("APP_PATH", dirname(dirname(__FILE__)));
define("DS", DIRECTORY_SEPARATOR);
define("CONTROLLER", DS . "application" . DS . "controllers" . DS);

// 2. load the Core class that includes an autoloader
require("../Framework/Core.php");
Framework\Core::initialize();

// 3. load and initialize the Configuration class
$configuration = new Framework\Configuration(array(
	"type" => "ini"
));
Framework\Registry::set("configuration", $configuration->initialize());

// 4. load and initialize the Database class - does not connect
$database = new Framework\Database(array(
	"type" => "pdo",
	"options" => array(
		"host"=>"localhost",
		"username"=>"root",
		"password"=>"",
		"schema"=>"prophpmvc",
		"port"=>"3306"
	)
));
Framework\Registry::set("database", $database->initialize()->connect());

// 5

// 6. load and initialize the Session class
$session = new Framework\Session();
Framework\Registry::set("session", $session->initialize());

// 7. load the Router class and provide the url+extension
$router = new Framework\Router(array(
	"url" => trim($_SERVER['REQUEST_URI'], "/")
));
Framework\Registry::set("router", $router);

// 8. dispach the current request
try {
	$router->dispatch();
} catch (Exception $e) {
	echo $e->getMessage();
}


// 9. unset global variables
unset($configuration);
unset($database);
unset($router);

/*

try {
	
	// Autoloader
	require "../Core/Autoload.php";
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
*/
