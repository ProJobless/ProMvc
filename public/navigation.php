<?php
define("APP_PATH", dirname(dirname(__FILE__)));
define("DS", DIRECTORY_SEPARATOR);
define("CONTROLLER", DS . "application" . DS . "controllers" . DS);
require("../Framework/Core.php");
Framework\Core::initialize();

$registry = \Framework\Registry::getListe();
var_dump($registry);

?>
<a href="/">home</a>
<?php if (isset($user)): ?>   
<a href = "/profile">profile</a>    
<a href = "/settings">settings</a>    
<a href = "/logout">logout</a> 
<?php 
else: ?>
<a href = "/register">register</a>    
<a href = "/login">login</a> 
<?php endif; ?>