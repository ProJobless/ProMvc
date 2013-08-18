<?php

namespace application\controllers;

use Framework\Registry;

use application\models\User;

use Framework\RequestMethods;

class Users extends \Framework\Shared\Controller {
	
	public function index()
	{
		var_dump("action index"); 
		//$view = $this->getActionView();
		
		
		//$view = $this->getWillRenderActionView();
		
		//$this->render();
	} 
	
	public function profile()
	{
		$session = Registry::get("session");
		$user = unserialize($session-> get("user", null));
		
		if (empty($user))
		{
			$user = new \StdClass();
			$user-> first = "Mr.";
			$user-> last = "Smith";
		}
		
		$this-> getActionView()-> set("user", $user);
	}
	
	public function login()
	{
		if (RequestMethods::post("login"))
		{
			$email = RequestMethods::post("email");
			$password = RequestMethods::post("password");
			
			$view = $this-> getActionView();
			$error = false;
			
			if (empty($email))
			{
				$view->set("email_error", "Email not provided");
				$error = true;
			}
			
			if (empty($password))
			{
				$view->set("password_error", "Password not provided");
				$error = true;
			}
			
			if (!$error)
			{
				$user = User::first(array(
						"email = ?" => $email,
						"password = ?" => $password,
						"live = ?" => true,
						"deleted = ?" => false
				));
				
				
				
				if (!empty($user))
				{
					$session = Registry::get("session");
					$session->set("user", serialize($user));
					
					header("location: /profile");
					exit();
				}
				else
				{
					$view->set("password_error", "Email adress and/or password are incorrect");
				}
				
				exit();
			}
		}
	}
	
	public function friend()
	{
		echo "into friend action";
	}
	
	public function register()
	{
		$view =  $this-> getActionView();
		
		if (RequestMethods::post("register"))
		{
			$user = new User(array(
				"first" => RequestMethods::post("first"),
				"last" => RequestMethods::post("last"),
				"email" => RequestMethods::post("email"),
				"password" => RequestMethods::post("password")
			));
			
			if ($user->validate())
			{
				$user->save();
				$view->set("success", true);
			}
			
			$view->set("errors", $user->getErrors());
		}
		else 
		{
			$view->set("errors", array());
		}
		
	}
	
	public function search()
	{
		$view =  $this-> getActionView();
		
		$query =  RequestMethods::post("query");    
		$order =  RequestMethods::post("order", "modified");    
		$direction =  RequestMethods::post("direction", "desc");    
		$page =  RequestMethods::post("page", 1);    
		$limit =  RequestMethods::post("limit", 10);
		
		$count =  0;    
		$users =  false;
		
		if (RequestMethods::post("search"))    
		{        
			$where =  array(            
					"SOUNDEX(first) =  SOUNDEX(?)" => $query,            
					"live =  ?" => true,            
					"deleted =  ?" => false        
			);
		
			$fields =  array(            
					"id", "first", "last"        
			);
		
			$count =  User::count($where);        
			$users =  User::all($where, $fields, $order, $direction, $limit, $page);    
		}
		
		$view        
			-> set("query", $query)        
			-> set("order", $order)        
			-> set("direction", $direction)        
			-> set("page", $page)        
			-> set("limit", $limit)        
			-> set("count", $count)        
			-> set("users", $users);
	}
	
	public function settings()
	{

		$view = $this->getActionView();
		$user = $this->getUser();
		
		if (RequestMethods::post("update"))
		{
			$user = new User(array(
				"first" => RequestMethods::post("first", $user->first),
				"last" => RequestMethods::post("last", $user->last),
				"email" => RequestMethods::post("email", $user->email),
				"password" => RequestMethods::post("password", $user->password)
			));
			
			if ($user->validate())
			{
				$user->save();
				$view->set("success", true);
			}
			
			$view->set("errors", $user->getErrors());
		}
		else
		{
			$view->set("errors", array());
		}
	}
	
	public function logout()
	{
		$this->setUser(false);
		
		$session = Registry::get("session");
		$session->erase("user");
		
		header("Location: /login");
		exit();
	}
}
