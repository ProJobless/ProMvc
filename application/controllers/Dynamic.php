<?php

namespace application\controllers;

use Framework\Registry;

class Dynamic extends \Framework\Shared\Controller {
	
	/**
	 * @before _secure
	 */
	public function index()
	{
		$view = $this->getActionView();
		
		// get the name
		$name = "page1";
		$right_components = "";
		$left_components = "";
		$center_components = "";
		
		// load xml : simplexml
		$xml = simplexml_load_file(APP_PATH . '/application/configuration/dynamic.xml');
		foreach ($xml->route as $route)
		{
			if ($route->name == $name)
			{
				foreach ($route->right->component as $oComponent)
				{
					// set the template component
					$component = $oComponent->attributes()['name'];
					$right_components.="{% include 'components/{$component}/{$component}.tpl' %}";
					
					if ($oComponent->attributes()['core'] == "false")
					{
						$name = '\application\components\\' . $component . '\\' . ucfirst($component);
						$instance = new $name;
						$instance->initialize($oComponent->params);
						
						foreach ($instance->templateVar() as $template_var => $var)
						{
							$view->set($template_var, $var);
						}
					}
				}
				
				foreach ($route->left->component as $oComponent)
				{
					// set the template component
					$component = $oComponent->attributes()['name'];
					$left_components.="{% include 'components/{$component}/{$component}.tpl' %}";
					
					if ($oComponent->attributes()['core'] == "false")
					{
						$name = '\application\components\\' . $component . '\\' . ucfirst($component);
						$instance = new $name;
						$instance->initialize($oComponent->params);
					
						foreach ($instance->templateVar() as $template_var => $var)
						{
							$view->set($template_var, $var);
						}
					}
				}
				
				foreach ($route->center->component as $oComponent)
				{
					// set the template component
					$component = $oComponent->attributes()['name'];
					$center_components.="{% include 'components/{$component}/{$component}.tpl' %}";
						
					if ($oComponent->attributes()['core'] == "false")
					{
						$name = '\application\components\\' . $component . '\\' . ucfirst($component);
						$instance = new $name;
						$instance->initialize($oComponent->params);
							
						foreach ($instance->templateVar() as $template_var => $var)
						{
							$view->set($template_var, $var);
						}
					}
				}
			}
		}
		
		
		$right = $right_components;
		$left = $left_components;
		$center = $center_components;
		
		// 3 cases :
		// 3 colonnes 2-8-2
		// 2 colonnes 2-10 ou 10-2
		// 1 colonne 12
		if ($right == "" && $left == "")
		{
			$out_content = "<div class=\"col-md-12\">{$center}</div>";
		}
		else if ($right == "")
		{
			$out_content = "<div class=\"col-md-2\">{$left}</div>";
			$out_content.= "<div class=\"col-md-10\">{$center}</div>";
		}
		else if ($left == "")
		{
			$out_content = "<div class=\"col-md-10\">{$center}</div>";
			$out_content.= "<div class=\"col-md-2\">{$right}</div>";
		}
		else
		{
			$out_content = "<div class=\"col-md-2\">{$left}</div>";
			$out_content.= "<div class=\"col-md-8\">{$center}</div>";
			$out_content.= "<div class=\"col-md-2\">{$right}</div>";
		}
		
		$out = "
		<div class=\"row\">
		{$out_content}
		</div>
		";
		
		file_put_contents(APP_PATH . "/application/views/dynamic/index.tpl", $out);
	}
}

