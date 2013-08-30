<?php

namespace application\models;

use Framework\Shared\Model;

class News extends Model {
	
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
	 * @length 255
	 *
	 * @validate required, min(3)
	 * @label title
	 */
	protected $_title;
	
	/**
	 * @column
	 * @readwrite
	 * @type integer
	 */
	protected $_user;
	
	/**
	 * @column
	 * @readwrite
	 * @type text
	 */
	protected $_content;
}