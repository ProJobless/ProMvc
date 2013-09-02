<?php

namespace application\components\Account;

/**
 * Displays user info
 * Displays logout link
 * Displays admin section link
 * @author sbo
 *
 */
class Account {
	
	private $_title;
	private $_uFirst;
	private $_uLast;
	private $_uAdmin;
	private $_ipAdress;
	
	public function getTitle() {return $this->_title;}
	public function setTitle($_title) {$this->_title = $_title;}
	public function getUFirst() {return $this->_uFirst;}
	public function getULast() {return $this->_uLast;}
	public function getUAdmin() {return $this->_uAdmin;}
	public function getIpAdress() {return $this->_ipAdress;}
	public function setUFirst($_uFirst) {$this->_uFirst = $_uFirst;}
	public function setULast($_uLast) {$this->_uLast = strtoupper($_uLast);}
	public function setIpAdress($_ipAdress) {$this->_ipAdress = $_ipAdress;}
	
	/**
	 * Constructor : Initializes properties
	 * @param string $_title
	 * @param string $_uFirst
	 * @param string $_uLast
	 * @param string $_uAdmin
	 */
	public function initialize($_title, $_uFirst, $_uLast, $_uAdmin)
	{
		$this->setTitle($_title);
		$this->setUFirst($_uFirst);
		$this->setULast($_uLast);
		$this->setUAdmin($_uAdmin);
		$this->setIpAdress($_SERVER['REMOTE_ADDR']);
	}
	
	/**
	 * sets $_uAdmin
	 * @param string $_uAdmin
	 */
	protected function setUAdmin($_uAdmin) 
	{
		switch ($_uAdmin)
		{
			case "1":
				$_uAdmin = "admin";
				break;
			default:
				$_uAdmin = "user";
				break;
		}
		
		$this->_uAdmin = $_uAdmin;
	}
	
	public function getAdminSectionLink()
	{
		if ($this->_uAdmin == "admin")
		{
			return "admin";
		}	
		return null;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getLogoutLink()
	{
		return "logout";
	}
	
	/**
	 * @return array
	 */
	public function templateVar()
	{
		$r= array();
		$r['account_title'] = $this->getTitle();
		$r['account_first'] = $this->getUFirst();
		$r['account_last'] = $this->getULast();
		$r['account_admin'] = $this->getUAdmin();
		$r['account_ip_adress'] = $this->getIpAdress();
		$r['account_logout'] = $this->getLogoutLink();
		$r['account_admin_link'] = $this->getAdminSectionLink();
		return $r;
	}
}
