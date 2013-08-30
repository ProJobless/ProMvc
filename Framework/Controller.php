<?php

namespace Framework;

use Framework\Controller\Exception as Exception;

use \Framework\View as View;

class Controller extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_parameters;
	
	/**
	 * @readwrite
	 */
	protected $_layoutView;
	
	/**
	 * @readwrite
	 */
	protected $_actionView;
	
	/**
	 * @readwrite
	 */
	protected $_willRenderLayoutView = true;
	
	/**
	 * @readwrite
	 */
	protected $_willRenderActionView = true;
	
	/**
	 * @readwrite
	 */
	protected $_defaultPath = "application/views";
	
	/**
	 * @readwrite
	 */
	protected $_defaultLayout = "layouts/standard";
	
	/**
	 * @readwrite
	 */
	protected $_defaultExtension = "tpl";
	
	/**
	 * @readwrite
	 */
	protected $_defaultContentType = "text/html";
	
	/**
	 * @readwrite
	 */
	protected $_name;
	
	protected function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} method not implemented");
	}
	
	protected function _getExceptionForArgument()
	{
		return new Exception\Argument("Invalid argument");
	}
	
	public function __construct($options = array())
	{
		parent::__construct($options);
	
		if ($this->getWillRenderLayoutView())
		{
			$defaultPath = $this->getDefaultPath();
			$defaultLayout = $this->getDefaultLayout();
			$defaultExtension = $this->getDefaultExtension();
				
			$view = new View(array(
					"file" => APP_PATH."/{$defaultPath}/{$defaultLayout}.{$defaultExtension}",
					"filename" => "layouts/standard.tpl",
					"path" =>  APP_PATH."/{$defaultPath}/",
			));
				
			$this->setLayoutView($view);
		}
	
		if ($this-> getWillRenderLayoutView())
		{
			$router = Registry::get("router");
			$controller = $router->getController();
			$action = $router-> getAction();
				
			$view = new View(array(
					"file" => APP_PATH."/{$defaultPath}/{$controller}/{$action}.{$defaultExtension}",
					"filename" => "{$controller}/{$action}.{$defaultExtension}",
					"path" => APP_PATH."/{$defaultPath}/",
			));
				
			$this->setActionView($view);
		}
	}
	
	public function render()
	{
		$defaultContentType = $this->getDefaultContentType();
		$results = null;
		
		$doAction = $this->getWillRenderActionView() && $this->getActionView();
		$doLayout = $this->getWillRenderLayoutView() && $this->getLayoutView();
		
		try
		{
			
			if ($doAction)
			{
				$view = $this->getActionView();
				$results = $view->render();
			}
			
			if ($doLayout)
			{
				$view = $this->getLayoutView();
				$view->set("template", $results);
				$results = $view->render();
				
				header("Content-type: {$defaultContentType}");
				echo $results;
			}
			else if ($doAction)
			{
				header("Content-type: {$defaultContentType}");
				echo $results;
				
				// precaution against multiple render() calls
				$this->setWillRenderLayoutView(false);
				$this->setWillRenderActionView(false);
			}
		}
		catch (\Exception $e)
		{
			throw new View\Exception\Renderer("Invalid layout/template syntax");
		}
	}
	
	/**
	 * Returns the name of the current controller
	 * @return string
	 */
	protected function getName()
	{
		if (empty($this->name))
		{
			$this->_name = get_class($this);	
		}
		
		return $this->_name;
	}
	
	public function __destruct()
	{
		Events::fire("framework.controller.destruct.before", array($this->name));
		
		$this->render();
		
		Events::fire("framework.controller.destruct.after", array($this->name));
	}
	
	public function redirect($name)
	{
		$router = Registry::get("router");
		$list = $router->getRoutesByName();
		
		foreach ($list as $route)
		{
			if ($route->name == $name)
			{
				header("Location: ".BASE_URL."{$route->pattern}");
			}
		}
	}
}
