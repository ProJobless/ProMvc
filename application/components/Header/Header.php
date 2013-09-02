<?php

namespace application\components\header;

class Header {
	
	private $_title;
	private $_subtitle;
	private $_titleLink;
	
	public function getTitle() {return $this->_title;}
	public function setTitle($title) {$this->_title = $title;}
	public function getSubtitle() {return $this->_subtitle;}
	public function setSubtitle($subtitle) {$this->_subtitle = $subtitle;}
	public function getTitleLink() {return $this->_titleLink;}
	public function setTitleLink($_titleLink) {$this->_titleLink = $_titleLink;}
	
	/**
	 * Constructor
	 * @param array $params
	 */
	public function initialize($params)
	{
		$this->setTitle($params->title);
		$this->setSubtitle($params->subtitle);
		$this->setTitleLink($params->titlelink);
	}

	

	
	
}
