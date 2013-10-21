<?php

  include "Dotenv.php";
  Dotenv::load(dirname(__DIR__));

	session_start();
	if($_SESSION['login'] != true) {
		header("location: login.php");
	}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <div class="header-container">
      <header class="wrapper clearfix">
        <h1 class="title">ddots v1.0</h1>

        <nav>
          <ul>
            <li><a href="data.php?logout=yes">Logout</a></li>
          </ul>
        </nav>
      </header>
    </div>

    <div class="main-container">
      <div class="main wrapper clearfix">
      	<article>
          <header>
              <h1>Projects</h1>
              <ul>
    					<?php
    						$dirs = array_filter(glob($_ENV['DDOTS_DIR']), 'is_dir');
    						foreach($dirs as $dir) {
    							//var_dump($dir);
    							$dirname = end(explode('/', $dir));
    							?>
    							<li><a href="project.php?dir=<?=$dirname?>"><?=$dirname?></a></li>
    					<?php } ?>
					</ul>
                  </header>
                  <section>
                      <!--<p><a href="#">New project</a></p>-->
                  </section>
              </article>
          </div> <!-- #main -->
        </div> <!-- #main-container -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
