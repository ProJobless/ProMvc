<?php

namespace Framework;

class Router extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_url;
	
	/**
	 * @readwrite
	 */
	protected $_extension;
	
	/**
	 * @read
	 */
	protected $_controller;
	
	/**
	 * @read
	 */
	protected $_action;
	
	protected $_routes = array();
	
	public function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} method not implemented");
	}
	
	public function addRoute($route)
	{
		$this->_routes[] = $route;
		return $this;
	}
	
	public function removeRoute($route)
	{
		foreach ($this->_routes as $i => $stored)
		{
			if ($stored == $route)
			{
				unset($this->_routes[$i]);
			}
		}
	}
	
	public function getRoutes()
	{
		$list = array();
		
		foreach ($this->_routes as $route)
		{
			$list[$route->pattern] = get_class($route);
		}
		
		return $list;
	}
	
	public function dispatch()
	{
		$url        = $this->url;
		$parameters = array();
		$controller = "index";
		$action     = "index";
		
		
		foreach ($this->_routes as $route)
		{
			
			$matches = $route->matches($url);
			if ($matches)
			{
				$controller = $route->controller;
				$action     = $route->action;
				$parameters = $route->parameters;
				
				$this->_pass($controller, $action, $parameters);
				return;
			}
		}
		$parts = explode("/", trim($url, "/"));
		if (sizeof($parts) > 0)
		{
			if (sizeof($parts) == 1 && $parts[0] != "") 
			{
				$controller = $parts[0];
			}
			
			if (sizeof($parts) >= 2)
			{
				$controller = $parts[0];
				$action = $parts[1];
				$parameters = array_slice($parts, 2);
			}
		}
		
		$this->_pass($controller, $action, $parameters);
	}
	
	public function _pass($controller, $action, $parameters = array())
	{
		$name = ucfirst($controller);
		
		$this->_controller = $controller;
		$this->_action = $action;
		
		try 
		{	
			$name = ($name == '') ? 'Home' : $name;
			$controller = CONTROLLER . $name;
			$instance = new $controller(array(
					"parameters" => $parameters
			));
			Registry::set("controller", $instance);
		}
		catch (\Exception $e)
		{
			throw new \Exception("Controller {$name} not found");
		}
		
		if (!method_exists($instance, $action))
		{
			$instance->willRenderLayoutView = false;
			$instance->willRenderActionView = false;
			
			throw new \Exception("Action {$action} not found");
		}
		
		$inspector = new Inspector($instance);
		$methodMeta = $inspector->getMethodMeta($action);
		
		if (!empty($methodMeta["@protected"]) || !empty($methodMeta["@private"]))
		{
			throw new \Exception("Action {$action} not found");
		}
		
		$hooks = function($meta, $type) use ($inspector, $instance)
		{
			if (isset($meta[$type]))
			{
				$run = array();
				
				foreach ($meta[$type] as $method)
				{
					$hookMeta = $inspector->getMethodMeta($method);
					
					if (in_array($method, $run) && !empty($hookMeta["@once"]))
					{
						continue;
					}
					
					$instance->$method();
					$run[] = $method;
				}
			}
		};
		
		$hooks($methodMeta, "@before");
		
		call_user_func_array(array(
			$instance,
			$action
		), is_array($parameters) ? $parameters : array());
		
		$hooks($methodMeta, "@after");
		
		// unset controller
		
		Registry::erase("controller");
	}

}
