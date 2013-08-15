<?php

// 1. define the default path for includes
define("APP_PATH", dirname(dirname(dirname(__FILE__))));
define("DS", DIRECTORY_SEPARATOR);
define("CONTROLLER", DS . "application" . DS . "controllers" . DS);

// 2. load the Core class that includes an autoloader
require("../../Framework/Core.php");
Framework\Core::initialize();

$database = new Framework\Database(array(
"type" => "pdo",
"options" => array(
"host" => "localhost",
"username" => "root",
"password" => "",
"schema" => "prophpmvc"
)
));
$database = $database->initialize();
$database = $database->connect();
Framework\Registry::set("database", $database);

class Example extends Framework\Model
{
/**
* @readwrite
* @column
* @type autonumber
* @primary
*/
protected $_id;

/**
* @readwrite
* @column
* @type text
* @length 32
*/
protected $_name;

/**
* @readwrite
* @column
* @type datetime
*/
protected $_created;
}

Framework\Test::add(
function() use ($database)
{
$example = new Example();
return ($database->sync($example) instanceof Framework\Database\Connector\Pdo);
},
"Model syncs",
"Model"
);

Framework\Test::add(
function() use ($database)
{
	$example = new Example(array(
			"name" => "foo",
			"created" => date("Y-m-d H:i:s")
	));
	return ($example->save() > 0);
},
"Model inserts rows",
"Model"
);

Framework\Test::add(
function() use ($database)
{
	return (Example::count() == 1);
},
"Model fetches number of rows",
"Model"
);

Framework\Test::add(
function() use ($database)
{
	$example = new Example(array(
			"name" => "foo",
			"created" => date("Y-m-d H:i:s")
	));
	$example->save();
	$example->save();
	$example->save();
	return (Example::count() == 2);
},
"Model saves single row multiple times",
"Model"
);

Framework\Test::add(
function() use ($database)
{
	$example = new Example(array(
			"id" => 1,
			"name" => "hello",
			"created" => date("Y-m-d H:i:s")
	));
	$example->save();
	return (Example::first()->name == "hello");
},
"Model updates rows",
"Model"
);

Framework\Test::add(
function() use ($database)
{
	$example = new Example(array(
			"id" => 2
	));
	$example->delete();
	return (Example::count() == 1);
	},
	"Model deletes rows",
	"Model"
);

$run = Framework\Test::run();
var_dump($run);