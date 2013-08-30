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
        <link rel="stylesheet" href="{{ path_css }}normalize.min.css">
        <link rel="stylesheet" href="{{ path_css }}main.css">
        <!-- Bootstrap -->
    	<link href="{{ path_css }}bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">
    	<!-- Custum -->
        <link rel="stylesheet" href="{{ path_css }}portal.css">
        
        <!--  components -->
        <link rel="stylesheet" href="{{ path_css }}components/auth/auth.css">
        <link rel="stylesheet" href="{{ path_css }}components/news/news.css">
        <!-- cleditor -->
        <link rel="stylesheet" href="{{ path_css }}plugins/cleditor/jquery.cleditor.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="assets/js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
        
        <!-- amcharts -->
        <script src="{{ path_js }}amcharts/amcharts.js"></script>
        
        
        
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ path_js }}vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="{{ path_js }}plugins.js"></script>
        <script src="{{ path_js }}main.js"></script>
		
		<script src="{{ path_js }}bootstrap/bootstrap.min.js"></script>
        <script src="{{ path_js }}plugins/cleditor/jquery.cleditor.min.js"></script>
        
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
						<a href="/">Home</a>
					</li>
					<li>
						<a href="/news">News</a>
					</li>
				</ul>
			</div>
		</section>
		
		<!-- header -->
		<header id="header">
			<div class="container">
				<div id="title-position">
					<h1><a href="{{ header.getTitleLink }}">{{ header.getTitle }}</a></h1>
		    		<span id="subtitle">{{ header.getSubtitle }}</span>
				</div>
			</div>
		</header>
		
		<!-- container -->
		<section id="container">
			<div class="container">
				{{ template }}
			</div>
		</section>

		
        

        
		
		
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>

