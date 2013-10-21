<?php
	session_start();

	function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }
	
	    return (substr($haystack, -$length) === $needle);
	}
	
	$project = $_GET['play'];
	$dir = 'D:/wamp/www/Dropbox/Project323/'.$project;
	$filename = $dir."/".".ddots";
	
	
	$file = file_get_contents($filename, true);
	if(isset($_SESSION['login']) && $_SESSION['login'] != true) {
		if($file != 'public=1') {
			header("location: buncherror.php");
		}
	}

	
	
?>

<style type="text/css">
	
	body {
	    margin: 0;
	    padding: 0;
		background-color: black;
		width: 100%;
		height: 100%;
		display: table;
	}
	body[orient="portrait"] { min-height:540px; }
	body[orient="landscape"] { min-height:400px; }
	#mainfancybox {
		display:table-cell;
	    text-align: center;
	    vertical-align: middle;
	} 
	#mainfancybox img {
		height: 100%;
	}
	
	.hidden {
		/*  */
		display: none;
	  }
	.graydiv {
		position: absolute;
		background-color: transparent;
		opacity: 0.5;
	}	
	
</style>

<div id="mainfancybox" style="">
</div>

<div class="hidden">
	<?php
		if ($handle = opendir($dir)) {
		    $blacklist = array('.', '..', '.dropbox', 'desktop.ini', 'links.config');
		    while (false !== ($file = readdir($handle))) {
		        if (!in_array($file, $blacklist) && endswith($file, '.png')) { ?>
		            <img src="includes/getimg.php?src=<?=$project.'/'.$file?>" filename="<?=$file?>" />
		        <?php }
		    }
		    closedir($handle);
		}
	
	?>
</div>
	

	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
<script type="text/javascript">
	
	var povezave = new Array();
		
	$(document).ready(function() {
		var imageTotal = $('img').length;
	    var imageCount = 0;        
	    $('img').load(function(){
	    	if(++imageCount == imageTotal) doStuff();
	    });
	});
	function doStuff() {
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
		
		setTimeout(function () {
	        // Hide the address bar!
	        window.scrollTo(0, 1);
	    }, 1000);
		    
		$(".hidden img").first().each(function(index) {
			$("#mainfancybox").append($(this));
			loadImg($(this));
		});
		
	}
	
	function loadImg() {
		mydiv = 0;
		for(i in povezave) {
			//console.log(povezave[i]['file1'] +"  ==   "+ $("#mainfancybox img").first().attr('filename'));
			if(povezave[i]['file1'] == $("#mainfancybox img").first().attr('filename')) {
				
				$("#mainfancybox").append("<div id='mydiv"+mydiv+"' class='graydiv'></div>");
		
				hm = $("#mainfancybox img").position().left;
				vm = parseFloat($("#mainfancybox img").offset().top);
		
				//console.log(hm + ", " + vm);
		
				//console.log("image size: " + $("#mainfancybox img").height());
				//console.log("image size: " + $("#mainfancybox img").width());
				
				k = parseFloat($("#mainfancybox img").height()) / 500;
			
				//console.log("k: " + k);
				//console.log("pos1y: " + povezave[i]['pos1Y']*k);
			
				$("#mydiv"+mydiv).css({
					left: (hm + parseFloat(povezave[i]['pos1X'])*k)+'px',
					top: (vm + povezave[i]['pos1Y']*k)+'px',
					width: ((povezave[i]['pos2X']-povezave[i]['pos1X'])*k)+'px',
					height: ((povezave[i]['pos2Y']-povezave[i]['pos1Y'])*k)+'px'
				}).attr('n', i)
				.click(function() {
					//console.log(parseFloat($(this).attr('n')));
					LinkClicked(parseFloat($(this).attr('n')));
				});
				mydiv++;
			}
		}
	}
	
	function LinkClicked(conID) {
		$(".hidden").append($("#mainfancybox img"));
		$("#mainfancybox .graydiv").remove();
		$(".hidden img").each(function(index) {
			if($(this).attr("filename") == povezave[conID]['file2']) {
				$(".hidden").append($(this).html());
				$("#mainfancybox").append($(this));
				loadImg();
			}
		});
	}
	
</script>