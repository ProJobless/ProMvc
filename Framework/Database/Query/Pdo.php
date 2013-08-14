<?php

namespace Framework\Database\Query;

use Framework\Database\Query;

class Pdo extends Query {
	
	public function all()
	{
		$sql = $this->_buildSelect();
		$result = $this->_connector->execute($sql);
	
		
		if ($result === false)
		{
			$error = $this->_connector->lastError;
			throw new \Exception("There was an error with your SQL query : {$error}");
		}
		
		$rows = array();
		
		for ($i=0; $i<$result->rowCount();$i++)
		{
			$rows[]=$result->fetch(\PDO::FETCH_OBJ);
		}
	
		return $rows;
		
	}
}

?>