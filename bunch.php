<?php

	include('includes/mysql_connect.php');

	if(isset($_GET['userhash'])) {
		$userhash = $_GET['userhash'];


		if(isset($_GET['a'])) {
			$anws = $_GET['a'];
			if($anws == '1') {
				mysql_query("UPDATE recipients SET accepted='1', dateresponded=NOW() WHERE hash='$userhash'") or die(mysql_error());
			} elseif($anws == '0') {
				mysql_query("UPDATE recipients SET accepted='-1', dateresponded=NOW() WHERE hash='$userhash'") or die(mysql_error());
			}
			header('location: bunch.php?userhash='.$userhash);
		}

	  	$query = mysql_query("SELECT * FROM Recipients WHERE hash = '$userhash'") or die(mysql_error());
	  	if($row = mysql_fetch_assoc($query)) {
	  		$name = $row['recipient'];
	  		$bunchid = $row['bunch_id'];
			$accepted = $row['accepted'];
			$experience = $row['experience'];
		} else {
			header('location: buncherror.php');
		}

	  	$query = mysql_query("SELECT * FROM Bunch WHERE id = '$bunchid'") or die(mysql_error());
	  	if($row = mysql_fetch_assoc($query)) {
			$event = $row['event'];
	      	$rquery = mysql_query("SELECT * FROM Recipients WHERE bunch_id = '".$row['id']."'");
			$location = $row['location'];
			$img = ($row['img']!="" ? "uploads/".$row['img'] : "http://placehold.it/300&text=No%20image");

	      	$time = strtotime($row['time']);
			$date = (date('Ymd') == date('Ymd', $time) ? "Today" : (date('Ymd', strtotime('tommorow')) == date('Ymd', $time) ? "Tommorow" : date('d.m.Y', $time)));

			$recipients = array();
			while($rrow = mysql_fetch_assoc($rquery)) {
				$recipients[] = $rrow['recipient'];//($rrow['accepted'] == 0 ? "Not yet" : ($rrow['accepted'] == 1 ? "Yes" : "No"))
			}
	      }	else {
			header('location: buncherror.php');
		}
	}/* elseif(isset($_GET['bunch'])) {
		$hash = $_GET['bunch'];
	  	$query = mysql_query("SELECT * FROM Bunch WHERE uniquehash = '$hash'") or die(mysql_error());
	  	if($row = mysql_fetch_assoc($query)) {
			$event = $row['event'];
	      	$rquery = mysql_query("SELECT * FROM Recipients WHERE idBunch = '".$row['idBunch']."'");
			$location = $row['location'];
			$img = $row['img'];

	      	$time = strtotime($row['time']);
			$date = (date('Ymd') == date('Ymd', $time) ? "Today" : (date('Ymd', strtotime('tommorow')) == date('Ymd', $time) ? "Tommorow" : date('d.m.Y', $time)));

			$recipients = array();
			while($rrow = mysql_fetch_assoc($rquery)) {
				$recipients[] = $rrow['recipient'];//($rrow['accepted'] == 0 ? "Not yet" : ($rrow['accepted'] == 1 ? "Yes" : "No"))
			}
	      }	else {
			header('location: buncherror.php');
		}
	}*/ else {
		header('location: buncherror.php');
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="assets/style.css"/>
    	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
		<title>bunch</title>
	</head>
	<body style="background: none;">
		<div class="card">
			<img class="img" src="<?=$img?>" />
			<div class="person">
				<div class="info"><?=implode(", ", $recipients)?></div>
			</div>
			<div class="time">
				<div class="info"><img src="assets/time.png" /><?=$date ?>, <?=date('g:i A', $time) ?></div>
			</div>

			<div class="location">
				<div class="info"><img src="assets/pin.png" /><?=$location ?></div>
			</div>

			<div class="response">
				<?php if($accepted == 0) { ?>
					<center class="rsptext"><?=$name?> are you comming?</center>
				    <a href="bunch.php?userhash=<?=$userhash?>&a=1" class="btn button btn-success">Yes</a>
				    <a href="bunch.php?userhash=<?=$userhash?>&a=0" class="btn button btn-danger pull-right">No</a>
				<?php } elseif($accepted == 1) { ?>
					<center class="rsptext"><?=$name?> you are comming.</center>
				<?php } elseif($accepted == -1) { ?>
					<center class="rsptext"><?=$name?> you are not comming.</center>
				<?php } ?>
			</div>
		</div>
		<div class="box">
		</div>
	</body>
</html>
