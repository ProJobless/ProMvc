<?php

namespace Framework;

use \Framework\Core\Exception as Exception;

/**
 * General structure of all classes
 * @author sbo
 *
 */
class Base {
	
	private $_inspector;
	
	/**
	 * Launch setters
	 * @param array $options which keys are setKeys(value)
	 */
	public function __construct($options = array())
	{
		$this->_inspector = new Inspector($this);
		
		if (is_array($options) || is_object($options))
		{
			foreach ($options as $key => $value)
			{
				$key = ucfirst($key);
				$method = "set{$key}";
				$this->$method($value);
			}
		}
	}
	
	public function __call($name, $arguments)
	{
		// checking to see that the inspector is set
		if (empty($this->_inspector))
		{
			throw new Exception\Exception("Call parent::__construct!");
		}
		
		// handling GetProperty() methods
		$getMatches = StringMethods::match($name, "^get([a-zA-Z0-9]+)$");
		if (sizeof($getMatches) > 0)
		{
			$normalized = lcfirst($getMatches[0]);
			$property = "_{$normalized}";
			
			if (property_exists($this, $property))
			{
				$meta = $this->_inspector->getPropertyMeta($property);
				if (empty($meta["@readwrite"]) && empty($meta["@read"]))
				{
					throw $this->_getExceptionForWriteonly($normalized);
				}
				
				if (isset($this->$property))
				{
					return $this->$property;
				}
				
				return null;
			}
		}
		
		// handling SetProperty() methods
		$setMatches = StringMethods::match($name, "^set([a-zA-Z0-9]+)$");
		if (sizeof($setMatches) > 0)
		{
			$normalized = lcfirst($setMatches[0]);
			$property = "_{$normalized}";
			
			if (property_exists($this, $property))
			{
				$meta = $this->_inspector->getPropertyMeta($property);
				if (empty($meta["@readwrite"]) && empty($meta["@write"]))
				{
					throw $this->_getExceptionForReadonly($normalized);
				}
				if (!empty($meta["@notnull"]) && $arguments[0] === null)
				{
					throw $this->_getExceptionForNotnull($normalized);
				}
				
				$this->$property = $arguments[0];
				return $this;
			}
		}
		throw $this->_getExceptionForImplementation($name);
	}
	
	public function __get($name)
	{
		$function = "get" . ucfirst($name);
		return $this->$function();
	}
	
	public function __set($name, $value)
	{
		$function = "set" . ucfirst($name);
		return $this->$function($value);
	}
	
	protected function _getExceptionForReadonly($property)
	{
		return new Exception\ReadOnly("{$property} is read-only");
	}
	
	protected function _getExceptionForNotnull($property)
	{
		return new Exception\NotNull("{$property} can not set to null");
	}
	
	protected function _getExceptionForWriteonly($property)
	{
		return new Exception\WriteOnly("{$property} is write-only");
	}
	
	protected function _getExceptionForProperty($property)
	{
		return new Exception\Property("Invalid property");
	}
	
	protected function _getExceptionForImplementation($method)
	{
		return new Exception\Argument("{$method} method not implemented");
	}
}
