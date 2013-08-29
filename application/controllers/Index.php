<?php

namespace application\controllers;

use application\components\Account\Account;

use \Twig_Loader_String;
use \Twig_Environment;

use application\components\Bloc\Bloc;

use application\components\Graph;

use application\components\header\Header;

use application\models\User;

use Framework\Registry;


class Index extends \Framework\Shared\Controller {
	
	/**
	 * @once
	 * @protected
	 */
	public function init()
	{
		echo "<p>init</p>";
	}
	
	/**
	 * @protected
	 */
	public function authenticate()
	{
		echo "<p>authenticate</p>";
	}
	
	/**
	 * @before _secure
	 */
	public function index()
	{	
		$account = new Account(
			"Mon Compte",
			$this->getUser()->first, 
			$this->getUser()->last,
			$this->getUser()->admin
		);
		
		$view = $this->getActionView();
		$view
			->set("account_title", $account->getTitle())
			->set("account_first", $account->getUFirst())
			->set("account_last", $account->getULast())
			->set("account_admin", $account->getUAdmin())
			->set("account_ip_adress", $account->getIpAdress())
			->set("account_logout", $account->getLogoutLink())
			->set("account_admin_link", $account->getAdminSectionLink())
		;
	}
	
	/**
	 * @protected
	 */
	public function notify()
	{
		echo "<p>notify</p>";
	}
}

