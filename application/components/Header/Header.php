<?php

namespace application\components\header;

class Header {
	
	private $title;
	private $subtitle;
	
	public function __construct(array $params)
	{
		$this->setTitle($params['title']);
		$this->setSubtitle($params['subtitle']);
	}
	
	public function getTitle() {return $this->title;}
	public function setTitle($title) {$this->title = $title;}
	public function getSubtitle() {return $this->subtitle;}
	public function setSubtitle($subtitle) {$this->subtitle = $subtitle;}

	

	
	
}
