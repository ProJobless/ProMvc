<?php

namespace application\controllers;

class Admin extends \Framework\Shared\Controller {
	
	/**
	 * @before _secure, _admin
	 */
	public function index()
	{
		// load xml file
		$dom = new \DOMDocument();
		$dom->load( APP_PATH . '/application/configuration/dynamic.xml');
		
		// add a route
		$route = $dom->createElement('route');	
		$name = $dom->createElement('name');
		$nameText = $dom->createTextNode('page3');
		$name->appendChild($nameText);
		$route->appendChild($name);
		$dom->documentElement->appendChild($route);
		//$dom->save(APP_PATH . '/application/configuration/dynamic.xml'); // ok
		
		// remove route
		$name = "page3";
		$routes = simplexml_load_file(APP_PATH . '/application/configuration/dynamic.xml');
		$i = 2;
	
		//unset($routes->route[$i]); // ok
			
		$routes->saveXML(APP_PATH . '/application/configuration/dynamic.xml');
		
		
		// add component
		/* // ok
		$routes->route[2]->right->component->params->title = "test";
		
		$routes->saveXML(APP_PATH . '/application/configuration/dynamic.xml');
		$routes->route[2]->right->component->addAttribute('name', 'contact');
		$routes->route[2]->right->component->addAttribute('core', 'false');
		$routes->saveXML(APP_PATH . '/application/configuration/dynamic.xml');
		*/
	}
}
