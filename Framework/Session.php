<?php

namespace Framework;

use Framework\Session\Exception as Exception;

use Framework\Session\Driver\Server;

class Session extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_type;
	
	/**
	 * @readwrite
	 */
	protected $_options;
	
	protected function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} not implemented");
	}
	
	protected function _getExceptionForArgument()
	{
		return new Exception\Argument("Invalid Argument");
	}
	
	public function initialize()
	{
		$type = $this->getType();
		
		if (empty($type))
		{
			$configuration = Registry::get("configuration");
			
			if ($configuration)
			{
				$configuration = $configuration->initialize();
				$parsed = $configuration->parse("configuration/session");
				
				if (!empty($parsed->session->default) && !empty($parsed->session->default->type))
				{
					$type = $parsed->session->default->type;
					unset($parsed->session->default->type);
					
					$this->__construct(array(
						"type"    => $type,
						"options" => (array) $parsed->session->default
					));
				}
			}
		}
		
		if (empty($type))
		{
			throw new Exception\Argument("Invalid type");
		}
		
		switch ($type)
		{
			case "server":
				return new Server($this->getOptions());
				break;
			default:
				throw new Exception\Argument("Invalid type");
				break;
		}
	}
}

?>