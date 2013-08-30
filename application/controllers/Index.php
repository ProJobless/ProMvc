<?php

namespace application\controllers;

use application\models\News;

use application\components\Contact\Contact;

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
		
		
		$view = $this->getActionView();
		
		$db = Registry::get("database");
		
		$news = new News(array(
			"connector" => $db
		));
		$new = $news->count();
		if ($new == 0)
		{
			$db->sync($news);
		}
		
		
		
		
		$contact = new Contact(array(
			"title" => "Infos Contact"
		));
		
		$contact->addDirectique(array(
			User::first(array(
				"id=?" => "4"
			)),
			User::first(array(
				"id=?" => "2"
			))
		));
		
		
		
		$view
			->set("contact_title", $contact->title)
			->set("contact_directique", $contact->getDirectique())
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

