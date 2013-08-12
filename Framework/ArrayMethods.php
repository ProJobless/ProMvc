<?php

namespace Framework;

class ArrayMethods {
	
	public function __construct()
	{
		// do nothing
	}
	
	public function __clone()
	{
		// do nothing
	}
	
	public static function clean($array)
	{
		return array_filter($array, function ($item) {
			return !empty($item);
		});
	}
	
	public static function trim($array)
	{
		return array_map(function ($item) {
			return trim($item);
		}, $array);
	}
	
	/**
	 * Returns the object version of an array
	 * @param array $array
	 * @return \stdClass
	 */
	public static function toObject($array)
	{
		$result = new \stdClass();
		
		foreach ($array as $key => $value)
		{
			if (is_array($value))
			{
				$result->{$key} = self::toObject($value);
			}
			else 
			{
				$result->{$key} = $value;
			}
		}
		
		return $result;
	}
}

?>