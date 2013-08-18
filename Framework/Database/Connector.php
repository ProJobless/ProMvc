<?php

namespace Framework\Database;

use Framework\Database\Exception as Exception;

use Framework\Base;

class Connector extends Base {

	public function initialize()
	{
		return $this;
	}
	
	protected function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} method not implemented");
	}
}
