<?php

namespace Framework;

class Model extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_table;
	
	/**
	 * @readwrite
	 */
	protected $_connector;
	
	/**
	 * Data types our model understands
	 * is used both internally end externally fot validation
	 * @read
	 */
	protected $_types = array(
			"autonumber",
			"text",
			"integer",
			"decimal",
			"boolean",
			"datetime"
	);
	
	protected $_columns;
	protected $_primary;
	
	public function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} method not implemented");
	}
	
	public function getTable()
	{	
		if (empty($this->_table))
		{
			$explode = explode("\\", get_class($this));
			$this->_table = strtolower(StringMethods::singular(end($explode)));
		}
		return $this->_table;
	}
	
	public function getConnector()
	{
		if (empty($this->_connector))
		{
			$database = Registry::get("database");
			if (!$database)
			{
				throw new \Exception("No connector availible");
			}
			$this->_connector = $database->initialize();
		}
		
		return $this->_connector;
	}
	
	public function getColumns()
	{
		if (empty($this->_columns))
		{
			$primaries = 0;
			$columns = array();
			$class = get_class($this);
			$types = $this->types;
			$inspector = new Inspector($this);
			$properties = $inspector->getClassProperties();
			$first = function($array, $key)
			{
				if (!empty($array[$key]) && sizeof($array[$key]) == 1)
				{
					return $array[$key][0];
				}
				return null;
			};
			
			foreach ($properties as $property)
			{
				$propertyMeta = $inspector->getPropertyMeta($property);
				
				if (!empty($propertyMeta["@column"]))
				{
					$name = preg_replace("#^_#", "", $property);
					$primary = !empty($propertyMeta["@primary"]);
					$type = $first($propertyMeta, "@type");
					$length = $first($propertyMeta, "@length");
					$index = !empty($propertyMeta["@index"]);
					$readwrite = !empty($propertyMeta["@readwrite"]);
					$read = !empty($propertyMeta["@read"]) || $readwrite;
					$write = !empty($propertyMeta["@write"]) || $readwrite;
					$validate = !empty($propertyMeta["@validate"]) ? $propertyMeta["@validate"] : false;
					$label = $first($propertyMeta, "@label");
					
					if (!in_array($type, $types))
					{
						throw new \Exception("{$type} is not a valid type");
					}
							
					if ($primary)
					{
						$primaries++;
					}
					
					$columns[$name] = array(
						"raw" => $property,
						"name" => $name,
						"primary" => $primary,
						"type" => $type,
						"length" => $length,
						"index" => $index,
						"read" => $read,
						"write" => $write,
						"validate" => $validate,
						"label" => $label
					);
				}
			}
			
			if ($primaries !== 1)
			{
				throw new \Exception("{$class} must have exactly one @primary column");
			}
					
			$this->_columns = $columns;
		}
		
		return $this->_columns;
	}
	
	/**
	 * Returns a column by name
	 * @param string $name
	 * @return NULL|string
	 */
	public function getColumn($name)
	{
		if (!empty($this->_columns[$name]))
		{
			return $this->_columns[$name];
		}
		
		return null;
	}
	
	/**
	 * Loops through the columns, returning the one marked as primary
	 */
	public function getPrimaryColumn()
	{
		if (!isset($this->_primary))
		{
			$primary='';
			
			foreach ($this->columns as $column)
			{
				if ($column["primary"])
				{
					$primary = $column;
					break;
				}
			}
			
			$this->_primary = $primary;
		}
		
		return $this->_primary;
	}
}

?>