<?php

namespace Framework\Shared;

/**
 * Shared code available to all views
 * @author Tiao-Saysanavong
 *
 */
class Markup {
	
	public function __construct()        
	{            
		// do nothing        
	}
		
	public function __clone()        
	{            
		// do nothing        
	}
			
	public static function errors(array $array, $key, $separator = "<br />", $before = "<br />", $after = "")        
	{   
		if (isset($array[$key]))            
		{                
			return $before.join($separator, $array[$key]).$after;            
		}
		
		return "";
	}
	
}

?>