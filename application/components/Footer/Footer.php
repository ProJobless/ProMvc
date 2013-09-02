<?php

namespace application\components\Footer;

class Footer {
	
	private $_text;
	
	public function getText() {return $this->_text;}
	public function setText($_text) {$this->_text = $_text;}

	/**
	 * Constructor
	 * @param array $params
	 */
	public function initialize($params)
	{
		$this->setText($params->text);
	}
}
