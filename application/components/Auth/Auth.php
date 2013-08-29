<?php

namespace application\components\Auth;

use application\models\User;

class Auth {
	
	protected $_error_email = false;
	protected $_error_password = false;
	
	public function getError_email() {return $this->_error_email;}
	public function getError_password() {return $this->_error_password;}
	public function setError_email($_error_email) {$this->_error_email = $_error_email;}
	public function setError_password($_error_password) {$this->_error_password = $_error_password;}

	/**
	 * 
	 * @param string $email
	 * @param string $password
	 */
	public function validate($email, $password)
	{
		if (empty($email))
		{
			$this->setError_email(true);
		}
			
		if (empty($password))
		{
			$this->setError_password(true);
		}
		
		if ($this->_error_email || $this->_error_password)
		{
			return false;
		}
		
		return true;
	}
	
	public function match($email, $password)
	{
		$user = User::first(array(
				"email = ?" => $email,
				"password = ?" => $password,
				"live = ?" => true,
				"deleted = ?" => false
		));
		
		if (!empty($user))
		{
			return $user->id;
		}
		
		return false;
	}
}

?>