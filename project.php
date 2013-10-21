<?php

	session_start();
	include('includes/mysql_connect.php');
	if(!isset($_SESSION['login']) || $_SESSION['login'] == false) {
		header('location: login.php');
	}

	$admin = false;
	if(isset($_GET['admin'])) {
		if($_GET['admin'] == 'pass') {
			$admin = true;
		}
	}

	$userid = $_SESSION['loginid'];


	$dirname = $_GET['dir'];
	function endsWith($haystack, $needle) {
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }
	    return (substr($haystack, -$length) === $needle);
	}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FirstBunch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
    <style type="text/css">
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }


	.uploadedimg:hover {
		border: 1px solid #ddd;
		padding: 9px;
		cursor: pointer;
	}

	.uploadedimg {

		float: left;
		padding: 10px;
		margin: 10px 0 0 10px;
	}

	.uploadedimg img {
	    height: 200px;

	  }

	.uploadedimg div {
	    text-align: center;
	    color: #888;
	  }

	.editorimg {
	    /*  */

	    border:1px solid black;
	  }

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://twitter.github.io/bootstrap/assets/js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">FirstBunch v1.0</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <!--li><a href="index.php">My Bunches</a></li>
              <li><a href="createbunch.php">Create new Bunch</a></li-->
              <li class="active"><a href="ddots.php">ddots v1.0</a></li>
            </ul>
          </div><!--/.nav-collapse -->
          <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?=$_SESSION ['name']?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="logout.php">Logout</a></li>
                </ul>
              </li>
            </ul>
        </div>
      </div>
    </div>

    <div class="container">

	<ul class="breadcrumb">
	  <li><a href="ddots.php">ddots v1.0</a> <span class="divider">/</span></li>
	  <li class="active">Editing project</li>
	</ul>

      <div class="main wrapper clearfix">
            <h3>Project: <?=$dirname ?></h3>
        	<?php
				$dir = $_ENV['DDOTS_DIR']."/".$dirname;
				if ($handle = opendir($dir)) {
				    $blacklist = array('.', '..', '.dropbox', 'desktop.ini', 'links.config');
				    while (false !== ($file = readdir($handle))) {
				        if (!in_array($file, $blacklist) && endswith($file, '.png')) { ?>
				            <div class="uploadedimg">
				            	<a class="fancybox fancybox.ajax" href="editor.php?edit=<?=$dirname.'/'.$file?>">
				            		<img src="includes/getimg.php?src=<?=$dirname.'/'.$file?>" filename="<?=$file?>" />
				            	</a>
				            	<!--<div><?=$file?></div>-->
				            </div>
				        <?php }
				    }
				    closedir($handle);
				}

			?>
        </div> <!-- #main -->

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.4"></script>

    <script type="text/javascript">

		dirname = "<?=$dirname ?>";
		selectedFilename = "keks";

    	$(".fancybox").fancybox();
    	$(".fancybox").click(function() {

    		selectedFilename = $(this).children().first().attr("filename");
      	});

        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
  </body>
</html>
