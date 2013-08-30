<?php

namespace Framework\Shared;

use application\models\User;

use Framework\Events;

use application\components\header\Header;

use Framework\Registry;

use Framework\Router as Router;

class Controller extends \Framework\Controller {
	
	/**
	 * @readwrite
	 */
	protected $_user;
	
	/**
	 * Overrrides the $_user setter method
	 * @param unknown_type $user
	 * @return \Framework\Shared\Controller
	 */
	public function setUser($user)
	{
		$session = Registry::get("session");
		
		if ($user)
		{
			$session->set("user", $user->id);
		}
		else
		{
			$session->erase("user");
		}
		
		$this->_user = $user;
		return $this;
	}
	
	public function __construct($options=array())
	{
		parent::__construct($options);
		
		// connect to database
		$database = \Framework\Registry::get("database");
		$database->connect();
		
		// schedule: load user from session into the controller 
		// retrives a user row based on session data
		// it will occur before any action hooks or actions are executed
		Events::add("framework.router.beforehooks.before", function($parameters) {
			
			// var_dump("framework.router.beforehooks.before");
			
			$session = Registry::get("session");
			$controller = Registry::get("controller");
			$user = $session->get("user");
			// var_dump($user);
			
			//$user = unserialize($session->get("user", null));
			
			if ($user)
			{
				//echo "load user $user from session";
				//echo " - Set $user dans $ controller->user";
				$controller->user = User::first(array(
					"id = ?" => $user
				));
			}
		});
		
		// schedule: save user to session
		// stores a user reference to the session
		// it will occur after all the action hooks and actions are executed
		Events::add("framework.router.afterhooks.after", function($parameters) {
			
			//var_dump("framework.router.afterhooks.after");
			
			$controller = Registry::get("controller");
			
			if ($controller->user)
			{
				//echo "save user to session";
				//echo " - SET ! set 'user', " . $controller->user->id;
				$session = Registry::get("session");
				$session->set("user", $controller->user->id);
			}
		});
			
		Events::add("framework.router.afterhooks.after", function($parameters) {
			
			$view = $this->getActionView();
			$account = new \application\components\Account\Account(
				"Mon Compte",
				$this->getUser()->first, 
				$this->getUser()->last,
				$this->getUser()->admin
			);
			$view
				->set("account_title", $account->getTitle())
				->set("account_first", $account->getUFirst())
				->set("account_last", $account->getULast())
				->set("account_admin", $account->getUAdmin())
				->set("account_ip_adress", $account->getIpAdress())
				->set("account_logout", $account->getLogoutLink())
				->set("account_admin_link", $account->getAdminSectionLink())
			;
		});
		
		// schedule: disconnect from database
		Events::add("framework.controller.destruct.after", function($name) {
			$database = Registry::get("database");
			$database->disconnect(); 
		});
		
		
		
		
		
	
		// set the Header component
		$configuration = Registry::get("configuration");
		if ($configuration)
		{
			$configuration = $configuration->initialize();
			$parsed = $configuration->parse("configuration/configuration");
	
			if (!empty($parsed->config->component->header->title))
			{
				$cHeader = new Header(array(
					"title"     => $parsed->config->component->header->title,
					"subtitle"  => $parsed->config->component->header->subtitle,
					"titleLink" => "/"
				));
			}
		}
		
		$layout = $this->getLayoutView();
		$layout->set("header", $cHeader);
	}
	
	public function render()
	{
		/* if the user and view(s) are defined,
		 * assign the user session to the view(s)
		 */
		
		if ($this->getUser())    
		{        
			if ($this->getActionView())       
			{   
				$key = "user";
				if ($this->actionView->get($key, false))
				{
					$key = "__user";
				}         
				$this->getActionView()                
					->set($key, $this->getUser());        
			}
		
			if ($this->getLayoutView())        
			{            
				$key = "user";
				if ($this->layoutView->get($key, false))
				{
					$key = "__user";
				}
				$this->getLayoutView()                
					->set($key, $this->getUser());        
			}    
		}
		
		parent::render();
	}
	
	/**
	 * @protected
	 */
	public function _secure()
	{
		$user = $this->getUser();
		if (!$user)
		{
			header("Location: /login");
			exit();
		}
	}
	
	/**
	 * @protected
	 */
	public function _admin()
	{
		if (!$this->user->admin)
		{
			throw new Router\Exception\Controller("Not a valid admin user account");
		}
	}
}
