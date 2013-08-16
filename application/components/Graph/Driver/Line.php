<?php

namespace application\components\Graph\Driver;

use application\components\graph\Driver;

class Line extends Driver {
	
	public function __construct(array $options = null)
	{
		echo "Je suis un graph de type Line";
	}
}
