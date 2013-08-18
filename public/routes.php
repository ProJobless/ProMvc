<?php

// define routes

$routes = array(
		array(
			"pattern" => "register",
			"controller" => "users",
			"action" => "register"
		),
		array(
				"pattern" => "login",
				"controller" => "users",
				"action" => "login"
		),
		array(
				"pattern" => "logout",
				"controller" => "users",
				"action" => "logout"
		),
		array(
				"pattern" => "profile",
				"controller" => "users",
				"action" => "profile"
		),
		array(
				"pattern" => "search",
				"controller" => "users",
				"action" => "search"
		),
		array(
				// TODO : revoir matche avec parametres
				"pattern" => "friend/?",
				"controller" => "users",
				"action" => "friend",
				"parameters" => array("id")
		),
		array(
				"pattern" => ":name/profile",
				"controller" => "home",
				"action" => "index"
		),
);

// add defined routes

foreach ($routes as $route)
{
	$router->addRoute(new Framework\Router\Route\Simple($route));
}

// unset globals

unset($routes);