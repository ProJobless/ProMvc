<?php

namespace Framework\Database\Connector;

use Framework\Database\Connector;

class Pdo extends Connector {
	
	protected $_service;
	
	/**
	 * @readwrite
	 */
	protected $_host;
	
	/**
	 * @readwrite
	 */
	protected $_username;
	
	/**
	 * @readwrite
	 */
	protected $_password;
	
	/**
	 * @readwrite
	 */
	protected $_schema;
	
	/**
	 * @readwrite
	 */
	protected $_port = "3306";
	
	/**
	 * @readwrite
	 */
	protected $_charset = "utf8";
	
	/**
	 * @readwrite
	 */
	protected $_engine = "InnoDB";
	
	/**
	 * @readwrite
	 */
	protected $_isConnected = false;
	
	/**
	 * @read
	 */
	protected $_statement;
	
	/**
	 * Checks if connected to the database
	 * @return boolean
	 */
	protected function _isValidService()
	{
		$isEmpty = empty($this->_service);
		$isInstance = $this->_service instanceof \PDO;
	
		if ($this->isConnected && $isInstance && !$isEmpty)
		{
			return true;
		}
	
		return false;
	}
	
	/**
	 * Connects to the database
	 * @throws \Exception
	 * @return \Framework\Database\Connector\Pdo
	 */
	public function connect()
	{
		if (!$this->_isValidService())
		{
			$this->_service = new \PDO(
						'mysql:host='.$this->_host.';dbname='.$this->_schema.';port='.$this->_port, $this->_username, $this->_password,
array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8')
			);
			$this->_service->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				
			if (!$this->_service)
			{
				throw new \Exception("Unable to connect to service");
			}
				
			$this->isConnected = true;
		}
	
		return $this;
	}
	
	/**
	 * Disconnects from the database
	 * @return \Framework\Database\Connector\Pdo
	 */
	public function disconnect()
	{
		if ($this->_isValidService())
		{
			$this->isConnected = false;
			unset($this->_service);
		}
	
		return $this;
	}
	
	/**
	 * Returns a corresponding query instance
	 * @return \Framework\Database\Query\Mysql
	 */
	public function query()
	{
		return new \Framework\Database\Query\Pdo(array(
				"connector" => $this
		));
	}
	
	/**
	 * Executes the provided SQL statement
	 * @param string $sql
	 */
	public function execute($sql)
	{
		if (!$this->_isValidService())
		{
			throw new \Exception("Not connected to a valid service");
		}
		
		$this->_statement = $this->_service->query($sql);
		
		return $this->_statement;
	}
	
	/**
	 * Escapes the provided value to make it safe for queries
	 * @param string $value
	 * @throws \Exception
	 * @return string
	 */
	public function escape($value)
	{
		if (!$this->_isValidService())
		{
			throw new \Exception("Not connected to a valid service");
		}
	
		return $value;
	}
	
	/**
	 * Returns the ID of the last row to be inserted
	 * @throws \Exception
	 */
	public function getLastInsertId()
	{
		if (!$this->_isValidService())
		{
			throw new \Exception("Not connected to a valid service");
		}
	
		return $this->_service->lastInsertId();
	}
	
	/**
	 * Returns the number of rows affected by the last SQL query executed
	 * @throws \Exception
	 */
	public function getAffectedRows()
	{
		if (!$this->_isValidService())
		{
			throw new \Exception("Not connected to a valid service");
		}
		
		return $this->_statement->rowCount();
	}
	
}

?>