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
					if (is_string($component)) 
					{
						// set the template component
						$right_components.="{% include 'components/{$component}/{$component}.tpl' %}";
						
						// initialize components from the ini file
						if ($right->$component->core == "")
						{
							$name = '\application\components\\' . $component . '\\' . ucfirst($component);
							$instance = new $name;
							$instance->initialize($right->$component);
							
							foreach ($instance->templateVar() as $template_var => $var)
							{
								$view->set($template_var, $var);
							}
						}
						
					}
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
		
	}
	
	/**
	 * @protected
	 */
	public function notify()
	{
		echo "<p>notify</p>";
	}
}

