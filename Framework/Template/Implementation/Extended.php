<?php

namespace Framework\Template\Implementation;

use Framework\Template;

class Extended extends Standard {

	/**
	 * @readwrite
	 */
	protected $_defaultPath = "application/views";
	
	/**
	 * @readwrite
	 */
	protected $_defaultKey = "_data";
	
	/**
	 * @readwrite
	 */
	protected $_index = 0;
	
	public function __construct($options = array())
	{
		parent::__construct($options);
		
		$this-> _map = array(
				"partial" => array(
					"opener"  => "{partial",
					"closer"  => "}",
					"handler" => "_partial"
				),
				"include" => array(
					"opener"  => "{include",
					"closer"  => "}",
					"handler" => "_include"
				),
				"yield" => array(
					"opener"  => "{yield",
					"closer"  => "}",
					"handler" => "yield"
				)
		) + $this-> _map;
						
		$this-> _map["statement"]["tags"] = array(
				"set" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "set"
				),
				"append" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "append"
				),
				"prepend" => array(
					"isolated" => false,
					"arguments" => "{key}",
					"handler" => "prepend"
				)
		) + $this-> _map["statement"]["tags"];
	}
	
	protected function _include($tree, $content)
	{
		$template = new Template(array(
			"implementation" => new self()
		));
		
		$file = trim($tree["raw"]);
		$path = $this-> getDefaultPath();
		$content = file_get_contents(APP_PATH."/{$path}/{$file}");
		
		$template-> parse($content);
		$index = $this-> _index++;
		
		return "function anon_{$index}(\$_data){
			".$template-> getCode()."
		};\$_text[] = anon_{$index}(\$_data);";
	}
}
