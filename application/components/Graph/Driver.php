<?php

namespace application\components\graph;

use Framework\Base;

class Driver extends Base {
	
	protected $axe_x;
	
	public function initialize()
	{
		return $this;
	}
	
	protected function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} method not implemented");
	}
}
