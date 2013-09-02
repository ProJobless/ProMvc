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
		
		$right_components = "";
		
		if (($configuration = Registry::get("configuration")) != false)
		{
			$configuration = $configuration->initialize();
			$ini = $configuration->parse("configuration/configuration");
			
			$index = "index";
			if (isset($ini->config->page->$index->right))
			{
				$right = $ini->config->page->$index->right;
				foreach ($right as $component)
				{
					$right_components.="{% include 'components/{$component}/{$component}.tpl' %}";
				}
			}
			
		}
		
		$out = "
		<div class=\"row\">
			<div class=\"col-md-3\">.col-md-3</div>
		    <div class=\"col-md-7\">
		    	main
		    </div>
		    <div class=\"col-md-2\">
		    	{$right_components}
		    </div>
		</div>		
		";
		
		file_put_contents(APP_PATH . "/application/views/index/index.tpl", $out);
		
		
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

