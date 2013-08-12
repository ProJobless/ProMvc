<?php

namespace Framework\Configuration;

use Framework\Base as Base;

class Driver extends Base {
	
	protected $_parsed = array();
	
	public function initialize()
	{
		return $this;
	}
	
	protected function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} method not implemented");
	}
}

?>