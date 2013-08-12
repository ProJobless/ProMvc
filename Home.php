<?php

use Framework\Controller;

class Home extends Controller {
	
	
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
	 * @before init, authenticate, init
	 * @after notify
	 */
	public function index()
	{
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

?>