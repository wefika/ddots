<?php

	session_start();
	include('includes/mysql_connect.php');
	if(!isset($_SESSION['login']) || $_SESSION['login'] == false) {
		header('location: login.php');
	}

	$userid = $_SESSION['loginid'];

	if(isset($_POST['bsubmit'])) {
		//$bimg = $_POST['bimg'];
		$bname = $_POST['bname'];
		$brecipient1 = $_POST['brecipient1'];
		$brecipient2 = $_POST['brecipient2'];
		$brecipient3 = $_POST['brecipient3'];
		$brecipient4 = $_POST['brecipient4'];

		$bdate = $_POST['bdate'];
		$btime = $_POST['btime'];
		$blocation = $_POST['blocation'];
		$bsubmit = $_POST['bsubmit'];

		$timestamp = strtotime($bdate . " " . $btime);

		do {
			$uniqid = generateRandomString(5);
			$query = mysql_query("SELECT * FROM bunch WHERE uniquehash = '$uniqid'") or die(mysql_error());
		} while(mysql_num_rows($query) > 0);


		mysql_query("INSERT INTO bunch (event, time, location, owner_id, uniquehash) VALUES ('$bname', FROM_UNIXTIME($timestamp), '$blocation', '$userid', '$uniqid')") or die(mysql_error());

		$bunchid = mysql_insert_id();


		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$extension = end(explode(".", $_FILES["file"]["name"]));
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 2000000) //20MB
			&& in_array(strtolower($extension), $allowedExts)) {
				if ($_FILES["file"]["error"] > 0) {
			    	echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			    } else {
			    	$imgname = "b" . $bunchid . "." . $extension;
			    	move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $imgname);
					mysql_query("UPDATE Bunch SET img = '$imgname' WHERE id = '$bunchid'") or die(mysql_error());
		    	}
		} else {
			echo "Invalid file".$extension."<br/>";
			echo $_FILES["file"]["name"]."<br/>";
			echo $_FILES["file"]["type"]."<br/>";
			echo $_FILES["file"]["size"]."<br/>";
		}

		if($brecipient1 != null && $brecipient1 != "") {
			do {
				$uniqid = generateRandomString(5);
				$query = mysql_query("SELECT * FROM Recipients WHERE hash = '$uniqid'");
			} while(mysql_num_rows($query) > 0);

			mysql_query("INSERT INTO Recipients (recipient, bunch_id, hash) VALUES ('$brecipient1', '$bunchid', '$uniqid')") or die(mysql_error());

		}
		if($brecipient2 != null && $brecipient2 != "") {
			do {
				$uniqid = generateRandomString(5);
				$query = mysql_query("SELECT * FROM Recipients WHERE hash = '$uniqid'");
			} while(mysql_num_rows($query) > 0);

			mysql_query("INSERT INTO Recipients (recipient, bunch_id, hash) VALUES ('$brecipient2', '$bunchid', '$uniqid')") or die(mysql_error());
		}
		if($brecipient3 != null && $brecipient3 != "") {
			do {
				$uniqid = generateRandomString(5);
				$query = mysql_query("SELECT * FROM Recipients WHERE hash = '$uniqid'");
			} while(mysql_num_rows($query) > 0);

			mysql_query("INSERT INTO Recipients (recipient, bunch_id, hash) VALUES ('$brecipient3', '$bunchid', '$uniqid')") or die(mysql_error());
		}
		if($brecipient4 != null && $brecipient4 != "") {
			do {
				$uniqid = generateRandomString(5);
				$query = mysql_query("SELECT * FROM Recipients WHERE hash = '$uniqid'");
			} while(mysql_num_rows($query) > 0);

			mysql_query("INSERT INTO Recipients (recipient, bunch_id, hash) VALUES ('$brecipient4', '$bunchid', '$uniqid')") or die(mysql_error());
		}

		header('location: index.php');

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
  	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
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
              <li><a href="index.php">My Bunches</a></li>
              <li class="active"><a href="createbunch.php">Create new Bunch</a></li>
              <li><a href="ddots.php">ddots v1.0</a></li>
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

      <form class="form-horizontal" action="createbunch.php" method="POST" enctype="multipart/form-data">
		<fieldset>

		<!-- Form Name -->
		<legend>Creating a new Bunch</legend>

		<!-- File Button -->
		<div class="control-group">
		  <label class="control-label" for="bunchimg">Upload file:</label>
		  <div class="controls">
		    <input id="bunchimg" name="file" class="input-file" type="file">
		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="bname">Bunch name:</label>
		  <div class="controls">
		    <input id="bname" name="bname" type="text" placeholder="COFFEE" class="input-xlarge" required="">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="brecipient1">Recipient 1:</label>
		  <div class="controls">
		    <input id="brecipient1" name="brecipient1" type="text" placeholder="Recipient name" class="input-xlarge">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="brecipient2">Recipient 2:</label>
		  <div class="controls">
		    <input id="brecipient2" name="brecipient2" type="text" placeholder="Recipient name" class="input-xlarge">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="brecipient3">Recipient 3:</label>
		  <div class="controls">
		    <input id="brecipient3" name="brecipient3" type="text" placeholder="Recipient name" class="input-xlarge">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="brecipient4">Recipient 4:</label>
		  <div class="controls">
		    <input id="brecipient4" name="brecipient4" type="text" placeholder="Recipient name" class="input-xlarge">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="">Sender:</label>
		  <div class="controls">
		  	<label class="label"><?=$_SESSION['name'] ?></label>

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="btime">Bunch date:</label>
		  <div class="controls">
		    <input id="btime" name="bdate" type="text" placeholder="Click to select" class="input-xlarge datepicker">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="btime">Bunch time:</label>
		  <div class="controls">
		    <input id="btime" name="btime" type="text" placeholder="00:00" class="input-xlarge">

		  </div>
		</div>

		<!-- Text input-->
		<div class="control-group">
		  <label class="control-label" for="blocation">Bunch location:</label>
		  <div class="controls">
		    <input id="blocation" name="blocation" type="text" placeholder="Isabela" class="input-xlarge">

		  </div>
		</div>

		<!-- Button -->
		<div class="control-group">
		  <label class="control-label" for="bsubmit"></label>
		  <div class="controls">
		    <button id="bsubmit" name="bsubmit" class="btn btn-primary">Submit Bunch</button>
		  </div>
		</div>

		</fieldset>
		</form>


    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
  <script>
  $(function() {
    $( ".datepicker" ).datepicker();
  });
  </script>
  </body>
</html>
