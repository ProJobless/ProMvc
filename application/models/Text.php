<?php

namespace application\models;

class Text extends \Framework\Shared\Model {
	
	/**
	 * @column
	 * @readwrite
	 * @primary
	 * @type autonumber
	 */
	protected $_id;
	
	/**
	 * @column
	 * @readwrite
	 * @type text
	 */
	protected $_content;
}
