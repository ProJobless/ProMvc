<?php

namespace application\components;

use application\components\Graph\Driver\Pie;

use application\components\Graph\Driver\Line;

use Framework\Base;

class Graph extends Base {

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
			case "line":
				return new Line($this->options);
				break;
			
			case "pie":
				return new Pie($this->options);
				break;
				
			default:
			throw new \Exception("Invalid type");
			break;
		}
	}
}