<?php

namespace application\controllers;

use Framework\Registry;

use Framework\Controller;

class Index extends Controller {
	
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
	 */
	public function index()
	{
		$db = Registry::get("database");
		
		var_dump($db);
		
		$db->connect();
		$db->query()
			->from("users")
			->all()
		;
		
		echo "<p>here x)</p>";	
	}
	
	/**
	 * @protected
	 */
	public function notify()
	{
		echo "<p>notify</p>";
	}
}

