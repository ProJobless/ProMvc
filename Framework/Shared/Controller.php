<?php

namespace Framework\Shared;

use application\components\header\Header;

use Framework\Registry;

class Controller extends \Framework\Controller {
	
	/**
	 * @readwrite
	 */
	protected $_user;
	
	public function __construct($options=array())
	{
		parent::__construct($options);
		
		// database functionnality
		$database = \Framework\Registry::get("database");
		$database->connect();
		
		$session = \Framework\Registry::get("session");
		$user = unserialize($session->get("user", null));
		$this->setUser($user);
	
	
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
	
	public function render()
	{
		if ($this-> getUser())    
		{        
			if ($this-> getActionView())       
			{            
				$this->getActionView()                
					->set("user", $this->getUser());        
			}
		
			if ($this->getLayoutView())        
			{            
				$this->getLayoutView()                
					->set("user", $this->getUser());        
			}    
		}
		
		parent::render();
	}
}
