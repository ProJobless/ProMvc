<?php

namespace application\models;

use Framework\Shared as Shared;

class Message extends Shared\Model {

	/**
	 * @column
	 * @readwrite
	 * @type text
	 * @length 256
	 *
	 * @validate required
	 * @label body
	 */
	protected $_body;

	/**
	 * @column
	 * @readwrite
	 * @type integer
	 */
	protected $_message;

	/**
	 * @column
	 * @readwrite
	 * @type integer
	 */
	protected $_user;

	/**
	 * @column
	 * @readwrite
	 * @primary
	 * @type autonumber
	 */
	protected $_id;

	public function getReplies()
	{
		return self::all(array(
			"message = ?" => $this->getId(),
			"live = ?" => true,
			"deleted = ?" => false
		), array("*"), "created", "desc");
	}

	public static function fetchReplies($id)
	{
		$message = new Message(array(
			"id" => $id
		));
		return $message->getReplies();
	}

}
