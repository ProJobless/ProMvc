<?php

namespace Framework;

use Framework\Database\Exception as Exception;

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
		
		return new Exception\Implementation("{$method} method not implemented");
	}
	
	public function initialize()
	{
		if (!$this->type)
		{
			throw new Exception\Argument("Invalid type");
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
				throw new Exception\Argument("Invalid type");
				break;
		}
	}
	
	
}

?>