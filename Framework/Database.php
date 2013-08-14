<?php

namespace Framework;

use Framework\Database\Connector\Pdo;

use Framework\Database\Connector\Mysql;

class Database extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_type; // connector
	
	/**
	 * @readwrite
	 */
	protected $_options;
	
	protected function _getExceptionForImplementation($method)
	{
		var_dump($method);
		
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
			case "mysql":
				return new Mysql($this->options);
				break;
			case "pdo":
				return new Pdo($this->options);
				break;
			default:
				throw new \Exception("Invalid type");
				break;
		}
	}
	
	
}

?>