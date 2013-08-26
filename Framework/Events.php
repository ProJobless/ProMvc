<?php

namespace Framework;

class Events {
	
	private static $_callbacks = array();
	
	private function __construct()
	{
		// do nothing
	}
	
	private function __clone()
	{
		// do nothing
	}
	
	/**
	 * Adds the listeners
	 * @param string $type
	 * @param function $callback
	 */
	public static function add($type, $callback)
	{
		if (empty(self::$_callbacks[$type]))
		{
			self::$_callbacks[$type] = array();
		}
		
		self::$_callbacks[$type][] = $callback;
	}
	
	/**
	 * emits/triggers an event
	 * @param string $type
	 * @param unknown_type $parameters
	 */
	public static function fire($type, $parameters=null)
	{
		if (!empty(self::$_callbacks[$type]))
		{
			foreach (self::$_callbacks[$type] as $callback)
			{
				call_user_func($callback, $parameters);
			}
		}
	}
	
	/**
	 * removes the stored $callback from the $_callback array
	 * it requires a reference to the original callback that it should remove
	 * @param string $type
	 * @param unknown_type $callback
	 */
	public static function remove($type, $callback)
	{
		if (!empty(self::$_callbacks[$type]))
		{
			foreach (self::$_callbacks[$type] as $i => $found)
			{
				if ($callback == $found)
				{
					unset(self::$_callbacks[$type][$i]);
				}
			}
		}
	}
}
