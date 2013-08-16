<?php

namespace application\components\Contact;

use Framework\Base;

class Contact extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_directique = array();
	
	/**
	 * @readwrite
	*/
	protected $_costumers = array();
	
	protected function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} method not implemented");
	}
	
	public function addDirectique($users)
	{
		if (is_array($users))
		{
			foreach ($users as $user)
			{
				$this->_directique[] = $user;
			}
		}
		else $this->_directique[] = $users;
	
		return $this;
	}
}

?>