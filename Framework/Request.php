<?php

namespace Framework;

class Request extends Base {
	
	protected $_request;
	
	/**
	 * @readwrite
	 */
	public $_willFollow = true;
	
	/**
	 * @readwrite
	 */
	protected $_headers = array();
	
	/**
	 * @readwrite
	 */
	protected $_options = array();
	/**
	 * @readwrite
	*/
	protected $_referer;
	/**
	 * @readwrite
	 */
	protected $_agent;
	protected function _getExceptionForImplementation($method)
	{
		return new \Exception("{$method} not implemented");
	}
	protected function _getExceptionForArgument()
	{
		return new \Exception("Invalid argument");
	}
	public function __construct($options = array())
	{
		parent::__construct($options);
		$this-> setAgent(RequestMethods::server("HTTP_USER_AGENT", "Curl/PHP ".PHP_VERSION));
	}
	public function delete($url, $parameters = array())
	{
		return $this-> request("DELETE", $url, $parameters);
	}
	function get($url, $parameters = array())
	{
		if (!empty($parameters))
		{
			$url .= StringMethods::indexOf($url, "?") ? "&" : "?";
			$url .= is_string($parameters) ? $parameters : http_build_query($parameters, "", "&");
		}
		return $this-> request("GET", $url);
	}
	function head($url, $parameters = array())
	{
		return $this-> request("HEAD", $url, $parameters);
	}
}