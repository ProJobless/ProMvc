<?php

// 1. define the default path for includes
define("APP_PATH", dirname(dirname(dirname(__FILE__))));
define("DS", DIRECTORY_SEPARATOR);
define("CONTROLLER", DS . "application" . DS . "controllers" . DS);

// 2. load the Core class that includes an autoloader
require("../../Framework/Core.php");
Framework\Core::initialize();

Framework\Test::add(
function()
{
$configuration = new Framework\Configuration();
return ($configuration instanceof Framework\Configuration);
},
"Configuration instanciates in uninitialized state",
"Configuration"
);

Framework\Test::add(
function()
{
$configuration = new Framework\Configuration(array(
"type" => "ini"
));
$configuration = $configuration->initialize();
return ($configuration instanceof Framework\Configuration\Driver\Ini);
},
"Configuration\Driver\Ini initializes",
"Configuration\Driver\Ini"
);

Framework\Test::add(
function()
{
$configuration = new Framework\Configuration(array(
"type" => "ini"
));
$configuration = $configuration->initialize();

$parsed = $configuration->parse("configuration/_configuration");
return ($parsed->config->first == "hello" && $parsed->config->second->second == "bar");
},
"Configuration\Driver\Ini parses configuration files",
"Configuration\Driver\Ini"
);

$run = Framework\Test::run();

var_dump($run);