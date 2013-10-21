<?php

	$rootdir = "D:/wamp/www/Dropbox/Project323/";

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

	if(isset($_GET['dir']) && isset($_GET['public'])) {

		$dir = $_GET['dir'];

		$public = '0';
		if($_GET['public'] == 1) {
			$public = '1';
		}

		$filename = $rootdir.$dir."/".".ddots";
		file_put_contents($filename, "public=".$public, LOCK_EX);

	}

	$userid = $_SESSION['loginid'];

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
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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
              <!--<li><a href="index.php">My Bunches</a></li>
              <li><a href="createbunch.php">Create new Bunch</a></li>-->
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
	  <li class="active">ddots v1.0</li>
	</ul>

      <h3>ddots projects <small>discover files from Dropbox</small></h3>
      <table class="table table-hover">
      	<tr>
      		<th>#</th>
      		<th>Project <small class="muted" style="font-weight: normal">(no spaces in names, please)</small></th>
      		<th style="width: 100px">Edit</th>
      		<th style="width: 150px">Actions</th>
      		<th style="width: 70px">Link</th>
      		<th style="width: 70px">Preview</th>
      	</tr>

      	<?php
      $dirs = array_filter(glob($_ENV['DDOTS_DIR']), 'is_dir');
			$i = 1;
			foreach($dirs as $dir) {

				$filename = $dir."/".".ddots";
				$public = false;

				if(!file_exists($filename)) {
					//$file = fopen($filename, 'w') or die("can't open file");
					//fclose($file);
					file_put_contents($filename, "public=0", LOCK_EX);
				} else {
					$file = file_get_contents($filename, true);
					if($file == 'public=1') {
						$public = true;
					}
				}


				$dirname = end(explode('/', $dir)); ?>
				<tr>
					<td><?=$i++?></td>
					<td><a href="project.php?dir=<?=$dirname?>"><?=$dirname?></a></td>
					<td>
						<a href="project.php?dir=<?=$dirname?>" class="btn btn-small">Editor</a>
					</td>
					<td>
						<div class="btn-group">
							<?php if($public) { ?>
							  <a href="ddots.php?dir=<?=$dirname?>&public=0" class="btn btn-small">Private</a>
							  <a href="ddots.php?dir=<?=$dirname?>&public=1" class="btn btn-inverse disabled btn-small">Public</a>
							<?php } else { ?>
							  <a href="ddots.php?dir=<?=$dirname?>&public=0" class="btn btn-inverse disabled btn-small">Private</a>
							  <a href="ddots.php?dir=<?=$dirname?>&public=1" class="btn btn-small">Public</a>
							<?php } ?>
						</div>
					</td>
					<td>
						<?php if($public) { ?>
							<a href="newplayer.php?play=<?=$dirname?>">Link</a>
						<?php } else { ?>
							-
						<?php } ?>
					</td>
					<td>
						<a href="newplayer.php?play=<?=$dirname?>" class="btn btn-inverse btn-small"><i class="icon-play icon-white"></i></a>
					</td>
				</tr>
		<?php } ?>
      </table>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
  </body>
</html>
