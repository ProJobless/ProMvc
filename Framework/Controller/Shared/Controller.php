<?php

namespace Framework\Controller\Shared;

use Framework\Controller as FController;

class Controller extends FController {
	
	public function __construct($options=array())
	{
		parent::__construct($options);
		
		$database = \Framework\Registry::get("database");
		$database->connect();
	}
}

?>