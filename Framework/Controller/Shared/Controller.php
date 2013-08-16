<?php

namespace Framework\Controller\Shared;

use application\components\header\Header;

use Framework\Registry;

use Framework\Controller as FController;

class Controller extends FController {
	
	public function __construct($options=array())
	{
		parent::__construct($options);
		
		$database = \Framework\Registry::get("database");
		$database->connect();
		
		
		$configuration = Registry::get("configuration");
		if ($configuration)
		{
			$configuration = $configuration->initialize();
			$parsed = $configuration->parse("configuration/configuration");
		
			if (!empty($parsed->config->component->header->title))
			{
				$title = $parsed->config->component->header->title;
		
				$cHeader = new Header(array(
						"title" => $title
				));
			}
		}
		
		$layout = $this->getLayoutView();
		$layout->set("header", $cHeader);
	}
}

?>