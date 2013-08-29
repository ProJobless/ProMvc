<?php

namespace application\controllers;

use application\components\Auth\Auth;

use Framework\Shared\Markup;

use application\models\File;

use application\models\Friend;

use Framework\Registry;

use application\models\User;

use Framework\RequestMethods;

class Users extends \Framework\Shared\Controller {
	
	/**
	 * @before _secure, _admin
	 * @param int $id
	 */
	public function delete($id)
	{
		$user = User::first(array(
			"id=?" => $id
		));
		
		if ($user)
		{
			$user->live = false;
			$user->save();
		}
		
		self::redirect("/users/view");
	}
	
	/**
	 * @before _secure, _admin
	 * @param int $id
	 */
	public function undelete($id)
	{
		$user = User::first(array(
			"id=?" => $id
		));
		
		if ($user)
		{
			$user->live = true;
			$user->save();
		}
		
		self::redirect("/users/view"); 
	}
	
	/**
	 * @before _secure, _admin
	 */
	public function edit($id)
	{
		$errors = array();
		$first='';
		$last='';
		$password='';
		$email='';
		
		$user = User::first(array(
			"id=?" => $id
		));
		
		if (RequestMethods::post("save"))
		{
			$user->first = RequestMethods::post("first");
			$user->last = RequestMethods::post("last");
			$user->email = RequestMethods::post("email");
			$user->password = RequestMethods::post("password");
			$user->live = (boolean) RequestMethods::post("live");
			$user->admin = (boolean) RequestMethods::post("admin");
			
			if ($user->validate())
			{
				$user->save();
				$this->actionView->set("success", true);
			}
			
			$errors = $user->errors;
			$first    = Markup::errors($errors, "first");
			$last     = Markup::errors($errors, "last");
			$email    = Markup::errors($errors, "email");
			$password = Markup::errors($errors, "password");
		
		}
		
		$this->actionView
			->set("user", $user)
			->set("errors", $errors)
			->set("password", $password)
			->set("email", $email);
	}
	
	/**
	 * @before _secure, _admin
	 */
	public function view()
	{
		$this->actionView->set("users", User::all());
	}
	
	public function index()
	{
		var_dump("action index"); 
		//$view = $this->getActionView();
		
		
		//$view = $this->getWillRenderActionView();
		
		//$this->render();
	} 
	
	public function profile()
	{
		$controller = Registry::get("controller");
		$user = $controller->user;
		
		$this-> getActionView()
			->set("file_id", $user->file->id)
			->set("first", $user->first)
			->set("last", $user->last);
			
	}
	
	public function login()
	{
		$view = $this-> getActionView();
		$auth = new Auth();
		
		if (RequestMethods::post("login"))
		{
			$email = RequestMethods::post("email");
			$password = RequestMethods::post("password");
			
			if (!$auth->validate($email, $password)) 
			{
				if ($auth->getError_email())
				{
					$view->set("email_error", "Email not provided");
				}
				
				if ($auth->getError_password())
				{
					$view->set("password_error", "Password not provided");
				}
			}
			else 
			{
				if (!$auth->match($email, $password))
				{
					$view->set("password_error", "Email adress and/or password are incorrect");
				}
				else
				{
					$session = Registry::get("session");
					$session->set("user", $auth->match($email, $password));
					
					$this->redirect("home");
					exit();
				}
				
				exit();
			}
		}
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
				$this->_upload("photo", $user->id);
				$view->set("success", true);
			}
			
			$view
				->set("error_first", \Framework\Shared\Markup::errors($user->getErrors(), "first"))
				->set("error_last", \Framework\Shared\Markup::errors($user->getErrors(), "last"))
				->set("error_email", \Framework\Shared\Markup::errors($user->getErrors(), "email"))
				->set("error_password", \Framework\Shared\Markup::errors($user->getErrors(), "password"))
				->set("errors", $user->getErrors());
		}
		else 
		{
			$view
				->set("errors", array());
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
	
	/**
	 * @before _secure
	 */
	public function settings()
	{
		
		$session = Registry::get("session");
		$controller = Registry::get("controller");
		$user = $controller->user;
		
		$view = $this->getActionView();
		//$user = $this->getUser();
		
		if (RequestMethods::post("update"))
		{
			$user->first = RequestMethods::post("first");
			$user->last = RequestMethods::post("last");
			$user->email = RequestMethods::post("email");
			if (RequestMethods::post("password"))
			{
				$user->password = RequestMethods::post("password");
			}
			
			if ($user->validate())
			{
				$user->save();
				$this->_upload("photo", $user->id);
				$view->set("success", true);
			
				$session->erase("user");
				$session->set("user", $user->id);
				
				//header("location: /settings");
				//exit();
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
	
	/**
	 * @before _secure
	 */
	public function friend($id)
	{
		// only logued user
		$user = $this->getUser();
		
		$friend = new Friend(array(
				"user" => $user->id,
				"friend" => $id
		));
		
		$friend->save();
		
		header("Location: /search");
		exit();
	}
	
	/**
	 * @before _secure
	 */
	public function unfriend($id)
	{
		// only logued user
		$user = $this->getUser();
		
		$friend = Friend::first(array(
				"user" => $user->id,
				"friend" => $id
		));
		
		if ($friend)
		{
			$friend = new Friend(array(
					"id" => $friend->id
			));
			$friend->delete();
			
			header("Location: /search");
			exit();
		}
	}
	
	
	
	protected function _upload($name, $user)
	{
		if (isset($_FILES[$name]))
		{
			$file = $_FILES[$name];
			$path = APP_PATH . "/public/uploads/";
			
			$time = time();
			$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
			$filename = "{$user}-{$time}.{$extension}";
			
			if (move_uploaded_file($file["tmp_name"], $path.$filename))
			{
				$meta = getimagesize($path.$filename);
				
				if ($meta)
				{
					$width = $meta[0];
					$height = $meta[1];

					$file = new File(array(
						"name" => $filename,
						"mime" => $file["type"],
						"size" => $file["size"],
						"width" => $width,
						"height" => $height,
						"user" => $user
					));
					$file->save();
				}
			}
		}
	}
}
