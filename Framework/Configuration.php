<?php

namespace Framework;

class Configuration extends Base {
	
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
		return new \Exception("{$method} method not implemented");
	}
	
	public function initialize()
	{
		if (!$this->type)
		{
			throw new \Exception("Invalid type");
		}
		
		switch ($this->type)
		{
			case "ini":
				return new Configuration\Driver\Ini($this->options);
				break;
			default:
				throw new \Exception("Invalid type");
				break;
		}
	}
}

?>