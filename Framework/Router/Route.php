<?php

namespace Framework\Router;

use Framework\Router\Exception as Exception;

use Framework\Base as Base;

class Route extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_pattern;
	
	/**
	 * @readwrite
	 */
	protected $_controller;
	
	/**
	 * @readwrite
	 */
	protected $_action;
	
	/**
	 * @readwrite
	 */
	protected $_name;
	
	/**
	 * @readwrite
	 */
	protected $_parameters = array();
	
	public function _getExceptionForImplementation($method)
	{
		return new Exception\Implementation("{$method} method not implemented");
	}
}
