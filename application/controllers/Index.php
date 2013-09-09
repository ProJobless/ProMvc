<?php

namespace application\controllers;

use application\models\Text;

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
		
		$right = $right_components;
		$left = "";
		
		// 3 cases : 
		// 3 colonnes 2-8-2
		// 2 colonnes 2-10 ou 10-2
		// 1 colonne 12
		if ($right == "" && $left == "")
		{
			$out_content = "<div class=\"col-md-12\">main</div>";
		}
		else if ($right == "")
		{
			$out_content = "<div class=\"col-md-2\">{$left}</div>";
			$out_content.= "<div class=\"col-md-10\">main</div>";
		}
		else if ($left == "")
		{
			$out_content = "<div class=\"col-md-10\">main</div>";
			$out_content.= "<div class=\"col-md-2\">{$right}</div>";
		}
		else 
		{
			$out_content = "<div class=\"col-md-2\">{$left}</div>";
			$out_content.= "<div class=\"col-md-8\">main</div>";
			$out_content.= "<div class=\"col-md-2\">{$right}</div>";
		}
		
		$out = "
		<div class=\"row\">
			{$out_content}
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

