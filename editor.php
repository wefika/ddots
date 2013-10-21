<?php
$file = $_GET['edit'];


$arr = explode('/', $file);
$project = $arr[0];
$filename = $arr[1];

?>

<style type="text/css">
	
	#mainfancybox {
		width: 1000px;
	}
	
	.graydiv {
		position: absolute;
		background-color: gray;
		opacity: 0.5;
	}	
	
	.topss {
		
		display: none;
	}
	
	.console {
		float: left;
		width: 200px;
		height: 400px;
		
	}
	
	.screenselect {
		/*  */
		padding: 5px;
		height: 90px;
		background-color: #ddd;
	  }
	  .screenselect img {
		  /*  */
		  height: 90px;
		  margin-right: 5px;
		  cursor: pointer;
		}
</style>

<div id="mainfancybox" style="">
	
	
	<h2>Editor</h2>
	<div>
		<button class="addLink">Add Link</button>
		<button class="confirmLink" disabled>Confirm Link</button>
	</div>
	
	<div style="text-align: center">
		
	<div id="workspace" class="console"></div>
	<img id="selImg" height="500" src="includes/getimg.php?src=<?=$file?>" />
	</div>
	
	<div id="resizeDiv" style="display: none;background-color: red; position: absolute;"></div>
	<div id="screenselect" class="topss">
	<h3>Izberi novo lokacijo</h3>
	<div class="screenselect">
	</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		setTimeout(doStuff, 1000);
	});
	
	
	function doStuff() {
		conData = [ <?php
			$lines = explode("\n", str_replace("\r", "", trim(file_get_contents('D:/wamp/www/Dropbox/Project323/'.$project.'/links.config'))));
			echo "\"".implode("\", \"", $lines)."\""; ?>];
		
		povezave = new Array();
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
		
		mydiv = 0;
		for(i in povezave) {
			if(povezave[i]['file1'] == "<?=$filename?>") {
				
				$("#workspace").append("<div id='mydiv"+mydiv+"' class='graydiv'></div>");
		
		
				hm = $("#selImg").position().left;
				vm = parseFloat($("#selImg").offset().top);
				vm = vm-30;
				k = parseFloat($("#selImg").height()) / 500;
			
				$("#mydiv"+mydiv).css({
					left: (hm + parseFloat(povezave[i]['pos1X'])*k)+'px',
					top: (vm + povezave[i]['pos1Y']*k)+'px',
					width: ((povezave[i]['pos2X']-povezave[i]['pos1X'])*k)+'px',
					height: ((povezave[i]['pos2Y']-povezave[i]['pos1Y'])*k)+'px'
				}).attr('n', i)
				.click(function() {
					console.log("clicked Link");
				});
			}
			mydiv++;
		}
		
	}

	$('#resizeDiv')
	    .draggable()
	    .resizable();
	    
	$(".addLink").click(function() {
		
		$(".addLink").attr('disabled', 'disabled');
		$(".confirmLink").removeAttr('disabled');
		
		$('#resizeDiv').css({
			display: 'inline',
			top: '30px',
			left: '300px',
			width: '100px',
			height: '30px',
			opacity: '0.5'
		});
		
	
	});
	
	$(".uploadedimg img").each(function(index) {
		$(".screenselect").append($(this).clone());
	});
	
	$(".screenselect img").click(function() {
		console.log(dirname);
		console.log(selectedFilename);
		console.log($(this).attr('filename'));
		filename2 = $(this).attr('filename');
		console.log("pos x,y = " + posX + ", " + posY + " : " + pos2X + ", " + pos2Y );
		
		$.ajax({
		  type: "POST",
		  url: "data.php?saveConection=1",
		  data: {
		  	project: dirname,
		  	data: (selectedFilename+";"+filename2+";"+posX+";"+posY+";"+pos2X+";"+pos2Y)
		  },
		  success: function(datax) {
		  	console.log("Repsponse: " + datax);
		  }
		});
		
		
		$("#screenselect").css('display', 'none');
		$(".console").append("Uspešno shranjena povezava!");
	});
	
	var n = 0;

	$(".confirmLink").click(function() {
		
		posX = parseFloat($('#resizeDiv').position().left) - parseFloat($('#selImg').position().left);
		posY = parseFloat($('#resizeDiv').position().top) - parseFloat($('#selImg').position().top);
		
		width = parseFloat($('#resizeDiv').css('width'));
		height = parseFloat($('#resizeDiv').css('height'));
		
		pos2X = posX + width;
		pos2Y = posY + height;
		
		if(posX < 0) posX = 0;
		if(posY < 0) posY = 0;
		if(pos2X < 0) pos2X = 0;
		if(pos2Y < 0) pos2Y = 0;
		
		if(pos2X > parseFloat($('#selImg').css('width'))) pos2X = parseFloat($('#selImg').css('width'));
		if(pos2Y > parseFloat($('#selImg').css('height'))) pos2Y = parseFloat($('#selImg').css('height'));
		
		
		
		$("#mainfancybox").append("<div id='mydiv"+n+"' class='graydiv'></div>");
		
		$("#mydiv"+n).css({
			left: (parseFloat($('#selImg').position().left)+posX)+'px',
			top: (parseFloat($('#selImg').position().top)+posY)+'px',
			width: (pos2X-posX)+'px',
			height: (pos2Y-posY)+'px'
		});
		
		$('#resizeDiv').css('display', 'none');
		
		$(".confirmLink").attr('disabled', 'disabled');
		$(".addLink").removeAttr('disabled');
		n++;
		
		$("#screenselect").css('display', 'block');
		
	});
</script> 