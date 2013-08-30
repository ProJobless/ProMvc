<?php

namespace application\controllers;

use application\models\User;

use Framework\Shared\Markup;

use Framework\RequestMethods;

use Framework\Shared\Controller;

class News extends Controller {
	
	/**
	 * Displays news list
	 * @before _secure
	 */
	public function index()
	{
		$getall = \application\models\News::all(array("live=?"=>true, "deleted=?"=>false));
		//$user = $new->getUser();
		
		foreach ($getall as $i=> $new)
		{
			$news[$i]['id'] = $new->getId();
			$news[$i]['title'] = $new->getTitle();
			$news[$i]['content'] = $new->getContent();
			$news[$i]['author']  = User::first(array("id=?"=>$new->getUser()))->getFirst()." ".User::first(array("id=?"=>$new->getUser()))->getLast();
		}
		
		$this->actionView->set("news", $news);
	}
	
	/**
	 * Page role : Add a news
	 * @before _secure, _admin
	 */
	public function add()
	{
		$view =  $this-> getActionView();
		
		if (RequestMethods::post("add"))
		{
			$new = new \application\models\News(array(
				"title" => RequestMethods::post("title"),
				"content" => RequestMethods::post("content"),
				"user" => $this->getUser()->id
			));
			
			if ($new->validate())
			{
				$new->save();
				$view->set("news_success", true);
			}
			
			$view
				->set("news_error_title", \Framework\Shared\Markup::errors($new->getErrors(), "title"));
		}
	}
	
	/**
	 * Page role : Delete a news
	 * @before _secure, _admin
	 */
	public function delete($id)
	{
		$new = \application\models\News::first(array(
			"id=?" => $id
		));
		
		if ($new)
		{
			$new->deleted = true;
			$new->save();
		}
		
		self::redirect("news");
	}
	
	/**
	 * Page role : Edit a news
	 * @before _secure, _admin
	 */
	public function edit($id)
	{
		$new = \application\models\News::first(array(
				"id=?" => $id
		));
		$title="";
		
		if (RequestMethods::post("save"))
		{
			$new->title = RequestMethods::post("title");
			$new->content = RequestMethods::post("content");
			$new->live = (boolean) RequestMethods::post("live");
				
			if ($new->validate())
			{
				$new->save();
				$this->actionView->set("success", true);
			}
				
			$errors = $new->errors;
			$title  = Markup::errors($errors, "title");
		
		}
		
		$view =  $this-> getActionView();
		$view
			->set("news", $new)
			->set("news_title_error", $title);
	}
}
