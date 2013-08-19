<?php

namespace application\models;

use Framework\Shared as Shared;

class Friend extends Shared\Model {
	
	/**
	 * @column
	 * @readwrite
	 * @type integer
	 */
	protected $_user;
	
	/**
	 * @column
	 * @readwrite
	 * @type integer
	 */
	protected $_friend;
	
	/**
	 * @column
	 * @readwrite
	 * @primary
	 * @type autonumber
	 */
	protected $_id;
}

?>