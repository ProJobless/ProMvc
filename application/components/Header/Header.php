<?php

namespace application\components\header;

class Header {
	
	private $title;
	
	public function __construct(array $params)
	{
		$this->title = $params['title'];
	}
	
	public function getTitle() {return $this->title;}
	public function setTitle($title) {$this->title = $title;}

	
	
}

?>