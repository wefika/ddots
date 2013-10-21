<?php
	session_start();
	if($_SESSION['login'] != true) {
		header("location: login.php");
	}

?><?php $project = $_GET['play']; ?>

<style type="text/css">
	
	#mainfancybox {
		width: 1000px;
		text-align: center;
	} 
	#mainfancybox img {
		height: 500px;
	}
	.graydiv {
		position: absolute;
		background-color: transparent;
		opacity: 0.5;
	}	
	
</style>

<div id="mainfancybox" style="">
	
	
	<h2>Player</h2>
	
	<div style="text-align: center">
		
	</div>
</div>

	
	
<script type="text/javascript">
	
	var povezave = new Array();
	
	conData = [ <?php
		$lines = explode("\n", str_replace("\r", "", trim(file_get_contents('D:/wamp/www/Dropbox/Project323/'.$project.'/links.config'))));
		echo "\"".implode("\", \"", $lines)."\""; ?>];
	
	var n=0;
	for(i in conData) {
		tmparray = conData[i].split(';');
		povezave[n] = new Array();
		povezave[n]['file1'] = tmparray[0];
		povezave[n]['file2'] = tmparray[1];
		povezave[n]['pos1X'] = parseFloat(tmparray[2]);
		povezave[n]['pos1Y'] = parseFloat(tmparray[3]);
		povezave[n]['pos2X'] = parseFloat(tmparray[4]);
		povezave[n]['pos2Y'] = parseFloat(tmparray[5]);
		n++;
	}
	
	
	$(".uploadedimg img").first().each(function(index) {
		$("#mainfancybox").append($(this).clone());
		loadImg($(this).clone());
	});
		
	function loadImg() {
		mydiv = 0;
		for(i in povezave) {
			console.log(povezave[i]['file1'] +"  ==   "+ $("#mainfancybox img").first().attr('filename'));
			if(povezave[i]['file1'] == $("#mainfancybox img").first().attr('filename')) {
				
				$("#mainfancybox").append("<div id='mydiv"+mydiv+"' class='graydiv'></div>");
		
			
				$("#mydiv"+mydiv).css({
					left: (parseFloat($("#mainfancybox img").first().position().left)+povezave[i]['pos1X']-165)+'px',
					top: (parseFloat($("#mainfancybox img").first().position().top)+povezave[i]['pos1Y'])+'px',
					width: (povezave[i]['pos2X']-povezave[i]['pos1X'])+'px',
					height: (povezave[i]['pos2Y']-povezave[i]['pos1Y'])+'px'
				}).attr('n', i)
				.click(function() {
					console.log(parseFloat($(this).attr('n')));
					LinkClicked(parseFloat($(this).attr('n')));
				});
				
				
				mydiv++;
				
				
			}
		}
		
	}
	
	function LinkClicked(conID) {
		$("#mainfancybox img").remove();
		$("#mainfancybox .graydiv").remove();
		$(".uploadedimg img").each(function(index) {
			if($(this).attr("filename") == povezave[conID]['file2']) {
				$("#mainfancybox").append($(this).clone());
				loadImg();
			}
		});
	}
	
</script>