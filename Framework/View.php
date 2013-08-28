<?php

namespace Framework;

use Framework\View\Exception as Exception;

class View extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_file;
	
	/**
	 * @readwrite
	 */
	protected $_filename;
	
	/**
	 * @readwrite
	 */
	protected $_path;
	
	/**
	 * @read
	 */
	protected $_template;
	
	protected $_data = array();
	
	public function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} method not implemented");
	}
	
	public function _getExceptionForArgument()
	{
		return new Exception\Argument("Invalid argument");
	}
	
	public function __construct($options = array())
	{
		parent::__construct($options);

	}
	
	public function render()
	{
		if (!file_exists($this->getFile()))
		{
			return "";
		}
		
		//var_dump($this->getPath());
		//var_dump($this->getFilename());
		
		$loader = new \Twig_Loader_Filesystem($this->getPath());
		$this-> _template = new \Twig_Environment($loader, array('autoescape' => false));
		
		try{
			return $this->_template->render($this->getFilename(), $this->_data);
		}
		catch (\Exception $e)
		{
			echo $e->getMessage();
		}
		
	}
	
	public function get($key, $default = "")
	{
		if (isset($this->_data[$key]))
		{
			return $this->_data[$key];
		}
		
		return $default;
	}
	
	protected function _set($key, $value)
	{
		if (!is_string($key) && !is_numeric($key))
		{
			throw new Exception\Data("Key must be a string or a number");
		}
		
		$this->_data[$key] = $value;
	}
	
	public function set($key, $value = null)
	{
		if (is_array($key))
		{
			foreach ($key as $_key => $value)
			{
				$this->_set($_key, $value);
			}
			
			return $this;
		}
		
		$this->_set($key, $value);
		
		return $this;
	}
		
	public function erase($key)
	{
		unset($this->_data[$key]);
		return $this;
	}
}

?>