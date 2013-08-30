<?php

namespace application\controllers;

use Framework\Shared\Controller;

class News extends Controller {
	
	/**
	 * Displays news list
	 * @before _secure
	 */
	public function index()
	{
		
	}
	
	/**
	 * Page role : Add a news
	 * @before _secure, _admin
	 */
	public function add()
	{
		
	}
}
