<?php

namespace application\components\Text;

use Framework\Base;

class Text extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_content;
	
	public function initialize($params)
	{
		$this->_content = $params->content;
	}
	
	/**
	 * @return array
	 */
	public function templateVar()
	{
		$r= array();
		$r['text_content'] = $this->content;
		return $r;
	}
}
