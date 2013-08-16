<?php

namespace Framework\Shared;

use application\components\header\Header;

use Framework\Registry;

class Controller extends \Framework\Controller {
	
	public function __construct($options=array())
	{
		parent::__construct($options);
		
		// database functionnality
		$database = \Framework\Registry::get("database");
		$database->connect();
	
	
		// set the Header component
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
