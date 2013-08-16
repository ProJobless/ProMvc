<?php

namespace application\components\Bloc;

class Bloc {
	
	/**
	 * @readwrite
	 */
	protected $_title;
	
	/**
	 * @readwrite
	 */
	protected $_elements = array();
	
	public function _getExceptionForImplementation($method)
	{
		throw new \Exception("{$method} method not implemented");
	}
	
	public function addElement($element)
	{
		if (is_array($element))
		{
			foreach ($element as $one_element)
			{
				$this->_elements[] = $one_element;
			}
		}
		else $this->_elements[] = $element;
	
		return $this;
	}
}

?>