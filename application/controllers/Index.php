<?php

namespace application\controllers;

use Imagine\Gd\Imagine;

use application\components\Bloc\Bloc;

use application\components\Graph;

use application\components\header\Header;

use application\models\User;

use Framework\Registry;


class Index extends \Framework\Shared\Controller {
	
	/**
	 * @once
	 * @protected
	 */
	public function init()
	{
		echo "<p>init</p>";
	}
	
	/**
	 * @protected
	 */
	public function authenticate()
	{
		echo "<p>authenticate</p>";
	}
	
	/**
	 */
	public function index()
	{
		
		$i = new Imagine();
		
		
		var_dump("------------------------------");
		var_dump("------------------------------");
		var_dump("------------------------------");
		$layout = $this->getLayoutView();
		
		$g = new Graph(array("type" => "line"));
		$gLine = $g->initialize();
		
		$view = $this->getActionView();
		
		
		
		$bloc = new Bloc();
		$bloc->addElement($gLine);
		
		var_dump($bloc);
		
		$db = Registry::get("database");
		
		$all = $db->query()
			->from("users", array(
					"first_name",
					"last_name" => "surname"
					))
					->join("points", "points.id=users.id", array(
							"points" => "rewards"
					))
			->all();
		
		var_dump($all);
		
		/**
		/*$id = $db->query()
			->from("users")
			->save(array(
					"first_name" => "Philip",
					"last_name" => "Pitt"
					));
			
		echo "insert de id : $id";
		*/
		
		
		$affected = $db->query()
		->from("users")
		->where("first_name=?", "Liz")
		->delete();
		
		echo "suppression de $affected rows ";
		
		
		
		$db->query()
		->from("users")
		->where("first_name=?", "Patrick")
		->save(array(
				"modified" => date("Y-m-d H:i:s")
				));
		
		
		$count = $db->query()
		->from("users")
		->count();
		
		echo "There are $count rows ";
		
		
		$user = new User(array(
				"connector" => $db
				));
	
		$db->sync($user);
		
		$elijah = new User(array(
				
				"connector" => $db,
				"first" => "Bobby",
				"last" => "Johnson",
				"email" => "bobby@mvc.com",
				"password" => "password",
				"live" => true,
				"deleted" => false,
				"created" => date("Y-m-d H:i:s"),
				"modified" => date("Y-m-d H:i:s")
				
				));
		
		$elijah->save();
		
		$all = User::all(array(
				"last = ?" => "Johnson"
				));
		var_dump($all[0]->first);
		
		$elijah->delete();
		
		echo "<p>here x)</p>";	
	}
	
	/**
	 * @protected
	 */
	public function notify()
	{
		echo "<p>notify</p>";
	}
}

