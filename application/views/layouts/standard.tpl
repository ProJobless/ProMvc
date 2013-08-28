<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Site</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
		
		<!-- Boilerplate -->
        <link rel="stylesheet" href="assets/css/normalize.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <!-- Bootstrap -->
    	<link href="assets/css/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
    	<!-- Custum -->
        <link rel="stylesheet" href="assets/css/portal.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="assets/js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		
		<!-- top menu -->
		<section id="top-menu">
			<div class="container">
				<ul class="top-menu">
					<li>
						<a href="">Home</a>
					</li>
					<li>
						<a href="">Contact</a>
					</li>
				</ul>
			</div>
		</section>
		
		<!-- header -->
		<div id="header">
			<div class="container">
			
			</div>
		</div>
		
		<div id="main-wrapper">
			<h1>{{ header.getTitle }}</h1>
		    <h2>{{ header.getSubtitle }}</h2>
		    
		    {{ template }}
		</div>
		
        

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/main.js"></script>
		
		<script src="assets/js/bootstrap/bootstrap.min.js"></script>
		
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

