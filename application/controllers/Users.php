<?php

namespace application\controllers;

use Framework\Controller\Shared\Controller;

use application\models\User;

use Framework\RequestMethods;

class Users extends Controller {
	
	public function index()
	{
		var_dump("action index"); 
		//$view = $this->getActionView();
		
		
		//$view = $this->getWillRenderActionView();
		
		//$this->render();
	} 
	
	public function login()
	{
		echo "login !";		
	}
	
	public function friend()
	{
		echo "into friend action";
	}
	
	public function register()
	{
		
		var_dump("action register");
		
		if (RequestMethods::post("register"))
		{
			$first = RequestMethods::post("first");
			$last = RequestMethods::post("last");
			$email = RequestMethods::post("email");
			$password = RequestMethods::post("password");
			$view = $this-> getActionView();
			$error = false;
			if (empty($first))
			{
				$view-> set("first_error", "First name not provided");
				$error = true;
			}
			if (empty($last))
			{
				$view-> set("last_error", "Last name not provided");
				$error = true;
			}
			if (empty($email))
			{
				$view-> set("email_error", "Email not provided");
				$error = true;
			}
			if (empty($password))
			{
				$view-> set("password_error", "Password not provided");
				$error = true;
			}
			
			if (!$error)
			{
				$user = new User(array(
						"first" => $first,
						"last" => $last,
						"email" => $email,
						"password" => $password
				));
				$user-> save();
				$view-> set("success", true);
				
			}
			
		}
		
	}
}

?>