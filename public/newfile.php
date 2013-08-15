<?php

function lambda($_data)
{
	if (is_array($_data) && sizeof($_data)) 
	{
		extract($_data); 
	}
	
	$_text = array();
	
	$_text[] = "<h1>Register</h1>";
	
	return implode($_text);
}

$data = array("template" => "<b>Poulain</b>");

var_dump(lambda($data));