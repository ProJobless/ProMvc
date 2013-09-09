<?php

namespace application\components\Text;

use Framework\Base;

class Text extends Base {
	
	/**
	 * @readwrite
	 */
	protected $_title;
	
	/**
	 * @readwrite
	 */
	protected $_content;
	
	public function initialize($params)
	{
		$this->_title = $params->title;
		$text = \application\models\Text::first(array(
				"id=?" => $params->content
			));
		$this->_content = $text->content;
	}
	
	/**
	 * @return array
	 */
	public function templateVar()
	{
		$r= array();
		$r['text_title'] = $this->title;
		$r['text_content'] = $this->content;
		return $r;
	}
}
