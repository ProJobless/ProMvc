<?php

// 1. define the default path for includes
define("DEBUG", TRUE);
define("APP_PATH", dirname(dirname(__FILE__)));
define("DS", DIRECTORY_SEPARATOR);
define("CONTROLLER", DS . "application" . DS . "controllers" . DS);

//PUBLIC
define('BASE_URL',      'http://'.$_SERVER["SERVER_NAME"].'/');
define('ASSETS',        'http://'.$_SERVER["SERVER_NAME"].'/public/assets/');
define('CSS',           ASSETS.'css/');
define('JS',            ASSETS.'js/');



try {
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
	
	// include custom routes
	
	include("routes.php");
	
	// 8. dispach the current request
	$router->dispatch();
	
	
	
	// 9. unset global variables
	unset($configuration);
	unset($database);
	unset($session);
	unset($router);
}
catch (Exception $e)
{
	// list exceptions
	$exceptions = array(
		"500" => array(
				
				"Framework\Core\Exception\Argument",
				"Framework\Core\Exception\Implementation",
				"Framework\Core\Exception\Property",
				"Framework\Core\Exception\ReadOnly",
				"Framework\Core\Exception\WriteOnly",
				"Framework\Core\Exception\NotNull",
				
				"Framework\Configuration\Exception\Argument",
				"Framework\Configuration\Exception\Implementation",
				"Framework\Configuration\Exception\Syntax",
				
				"Framework\Controller\Exception\Argument",
				"Framework\Controller\Exception\Implementation",

				"Framework\Database\Exception\Argument",
				"Framework\Database\Exception\Implementation",
				"Framework\Database\Exception\Service",
				"Framework\Database\Exception\Sql",
				
				"Framework\Model\Exception\Connector",
				"Framework\Model\Exception\Implementation",
				"Framework\Model\Exception\Primary",
				"Framework\Model\Exception\Type",
				"Framework\Model\Exception\Validation",
			
				"Framework\Router\Exception\Implementation",
				
				"Framework\Session\Exception\Argument",
				"Framework\Session\Exception\Implementation",
				
				"Framework\Template\Exception\Argument",
				"Framework\Template\Exception\Implementation",
				"Framework\Template\Exception\Parser",
				
				"Framework\View\Exception\Argument",
				"Framework\View\Exception\Data",
				"Framework\View\Exception\Implementation",
				"Framework\View\Exception\Renderer"
		),
		"404" => array(
			"Framework\Router\Exception\Action",
			"Framework\Router\Exception\Controller"
		)
	);
	
	$exception = get_class($e);
	
	// attempt to find the appropriate template, and render
	
	foreach ($exceptions as $template => $classes)
	{
		foreach ($classes as $class)
		{
			if ($class == $exception)
			{
				header("Content-type: text/html");
				include(APP_PATH . "/application/views/errors/{$template}.php");
				exit;
			}
		}
	}
	
	// render fallback template
	
	header("Content-type: text/html");
	echo "An error occurred." . $e->getMessage();
	exit;
}



