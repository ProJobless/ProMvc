<?php

namespace application\controllers;

use application\models\Message;

use Framework\RequestMethods;

use Framework\Shared\Controller;

class Messages extends Controller {

	public function add()
	{
		$user = $this->getUser();

		if (RequestMethods::post("share"))
		{
			$message = new Message(array(
				"body" => RequestMethods::post("body"),
				"message" => RequestMethods::post("message"),
				"user" => $user->id
			));

			if ($message->validate())
			{
				$message->save();
				header("Location: /profile");
				exit();
			}
		}
	}
}

