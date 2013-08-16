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
	
	/**
	 * Converts a multidimentionnal array into a unidimentionnal array
	 * @param array $array
	 * @param array $return
	 * @return array
	 */
	public static function flatten($array, $return = array())
	{
		foreach ($array as $key => $value)
		{
			if (is_array($value) || is_object($value))
			{
				$return = self::flatten($value, $return);
			}
			else {
				$return[] = $value;
			}
		}
		
		return $return;
	}
	
	public static function first($array)
	{
		$values = array_values($array);
		return array_shift($values);
	}
	
	public static function last($array)
	{
		$values = array_values($array);
		return array_pop($values);
	}
}

