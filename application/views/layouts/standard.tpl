<!DOCTYPE HTML>
<html>
<head>
	<title>Portails</title>
	<meta charset="UTF-8" />
</head>
<body>
	
	<div>
		<h1>{{ header.getTitle }}</h1>
		{% include "navigation.html" %}
		{{ template }}
	</div>
	
</body>	
</html>