<?php

use Framework\StringMethods;

// Autoloader
require "Core/Autoload.php";
spl_autoload_register(array('autoloader', 'autoload'));

var_dump(StringMethods::match("contrl/action/param/divers", "/"));