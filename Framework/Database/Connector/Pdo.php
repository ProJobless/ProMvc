<?php

namespace Framework\Database\Connector;

use Framework\Database\Connector;

use \Framework\Database\Exception as Exception;

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
	
	
	public function __sleep()
	{
		
	}
	
	public function __wakeup()
	{
		
	}
	
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
	 * @throws Exception\Service
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
				throw new Exception\Service("Unable to connect to service");
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
			throw new Exception\Service("Not connected to a valid service");
		}
		
		$this->_statement = $this->_service->query($sql);
		
		return $this->_statement;
	}
	
	/**
	 * Escapes the provided value to make it safe for queries
	 * @param string $value
	 * @throws Exception\Service
	 * @return string
	 */
	public function escape($value)
	{
		if (!$this->_isValidService())
		{
			throw new Exception\Service("Not connected to a valid service");
		}
	
		return $value;
	}
	
	/**
	 * Returns the ID of the last row to be inserted
	 * @throws Exception\Service
	 */
	public function getLastInsertId()
	{
		if (!$this->_isValidService())
		{
			throw new Exception\Service("Not connected to a valid service");
		}
	
		return $this->_service->lastInsertId();
	}
	
	/**
	 * Returns the number of rows affected by the last SQL query executed
	 * @throws Exception\Service
	 */
	public function getAffectedRows()
	{
		if (!$this->_isValidService())
		{
			throw new Exception\Service("Not connected to a valid service");
		}
		
		return $this->_statement->rowCount();
	}
	
	/**
	 * Returns the last error of occur
	 * @throws Exception\Service
	 */
	public function getLastError()
	{
		if (!$this->_isValidService())
		{
			throw new Exception\Service("Not connected to a valid service");
		}
	
		return $this->_statement->errorInfo(); 
	}
	
	/**
	 * Converts the class/properties into a valid SQL query,
	 * and ultimately into a physical database table
	 * @param unknown_type $model
	 * @throws Exception\Sql
	 * @return \Framework\Database\Connector\Mysql
	 */
	public function sync($model)
	{	
		$lines = array();
		$indices = array();
		$columns = $model->columns;
		$template = "CREATE TABLE `%s` (\n%s,\n%s\n) ENGINE=%s DEFAULT CHARSET=%s;";
	
		foreach ($columns as $column)
		{
			$raw = $column["raw"];
			$name = $column["name"];
			$type = $column["type"];
			$length = $column["length"];
				
			if ($column["primary"])
			{
				$indices[] = "PRIMARY KEY (`{$name}`)";
			}
				
			if ($column["index"])
			{
				$indices[] = "KEY `{$name}` (`{$name}`)";
			}
				
			switch ($type)
			{
				case "autonumber":
					{
						$lines[] = "`{$name}` int(11) NOT NULL AUTO_INCREMENT";
						break;
					}
				case "text":
					{
						if ($length !== null && $length <= 255)
						{
							$lines[] = "`{$name}` varchar({$length}) DEFAULT NULL";
						}
	
						else
						{
							$lines[] = "`{$name}` text";
						}
						break;
					}
				case "integer":
					{
						$lines[] = "`{$name}` int(11) DEFAULT NULL";
						break;
					}
				case "decimal":
					{
						$lines[] = "`{$name}` float DEFAULT NULL";
						break;
					}
				case "boolean":
					{
						$lines[] = "`{$name}` tinyint(4) DEFAULT NULL";
						break;
					}
				case "datetime":
					{
						$lines[] = "`{$name}` datetime DEFAULT NULL";
						break;
					}
			}
		}
	
		$table = $model->table;
		$sql = sprintf(
				$template,
				$table,
				join(",\n", $lines),
				join(",\n", $indices),
				$this->_engine,
				$this->_charset
		);
	
		$result = $this->execute("DROP TABLE IF EXISTS {$table};");
		
		if ($result === false)
		{
			$error = $this->lastError;
			throw new Exception\Sql("There was an error in the query: {$error}");
		}
		
		$result = $this->execute($sql);
	
		if ($result === false)
		{
			$error = $this->lastError;
			throw new Exception\Sql("There was an error in the query: {$error}");
		}
			
		return $this;
	}
	
}

?>