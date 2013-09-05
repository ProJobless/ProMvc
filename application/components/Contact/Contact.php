<?php

namespace application\components\Contact;

use Framework\Base;
use application\models\User;

class Contact extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_id;
	
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
	
	public function initialize($params)
	{
		$this->_title = $params->title;
		
		foreach ($params->directique as $user_id)
		{
			$users[] = User::first(array(
				"id=?" => $user_id
			));
		}
		$this->addDirectique($users);
	}
	
	/**
	 * @return array
	 */
	public function templateVar()
	{
		$r= array();
		$r['contact_title'] = $this->title;
		$r['contact_directique'] = $this->getDirectique();
		return $r;
	}
}
