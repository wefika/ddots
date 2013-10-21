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
              <li class="active"><a href="#">My Bunches</a></li>
              <li><a href="createbunch.php">Create new Bunch</a></li>
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

      <h1>List of my Bunches</h1>
      <table class="table">
      	<tr>
      		<th></th>
      		<th>Event</th>
      		<th>Owner</th>
      		<th>Time</th>
      		<th>Location</th>
      		<th>Recipients</th>
      	</tr>

      	<?php

      	if($admin) {
      		$query = "SELECT * FROM Bunch";
      	} else {
      		$query = "SELECT * FROM Bunch WHERE owner_id = '$userid'";
      	}

      	$result = mysql_query($query);
		if(mysql_num_rows($result) > 0) {
	       	while($row = mysql_fetch_assoc($result)) {

		      	$time = strtotime($row['time']);
				$date = (date('Ymd') == date('Ymd', $time) ? "Today" : (date('Ymd', strtotime('tommorow')) == date('Ymd', $time) ? "Tommorow" : date('d.m.Y', $time)));

	       		?>
		      	<tr>
		      		<td><img src="" /></td>
		      		<td><?=$row['event'] ?></td>
		      		<td><?=$_SESSION['name'] ?></td>
		      		<td><?=$date ?>, <?=date('g:i A', $time) ?></td>
		      		<td><?=$row['location'] ?></td>
		      		<td>
		      			<ul>
		      			<?php
		      				$rquery = mysql_query("SELECT * FROM Recipients WHERE bunch_id = '".$row['id']."'");
							while($rrow = mysql_fetch_assoc($rquery)) { ?>
								<li><?=$rrow['recipient'] ?>: <?=($rrow['accepted'] == 0 ? "<label class='label'>Not yet</label>" : ($rrow['accepted'] == 1 ? "<label class='label label-success'>Yes</label>" : "<label class='label label-important'>No</label>"))?>
									<a target="_blank" href="bunch.php?userhash=<?=$rrow['hash']?>">Link</a>
								</li>
							<?php } ?>
		      			</ul>
		      		</td>
		      	</tr>
	      	<?php }
			} else { ?>
	      		<tr>
	      			<td colspan="20">You haven't created any Bunch yet, <a href="createbunch.php">click here to create a Bunch</a>.</td>
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
