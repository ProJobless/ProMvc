<?php

namespace application\components\Contact;

use Framework\Base;

class Contact extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_title;
	
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
	
	/**
	 * Adds user(s) into $_directique property
	 * @param array|various $users
	 * @return \application\components\Contact\Contact
	 */
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
	
	public function getDirectique()
	{
		foreach ($this->_directique as $i => $user)
		{
			$d[$i]['first'] = $user->first;
			$d[$i]['last'] = $user->last;
		}
		
		return $d;
	}
}

?>