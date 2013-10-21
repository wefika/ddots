<?php
	session_start();
	if($_SESSION['login'] != true) {
		header("location: login.php");
	}

 $dirname = $_GET['dir']; 
function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
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
        
		<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />

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
                        <li><a class="fancybox fancybox.ajax" id="playbtn" href="player.php?play=<?=$dirname?>">Play</a></li>
                        <li><a href="newplayer.php?play=<?=$dirname?>">Play(mobile)</a></li>
                        <li><a href="data.php?logout=yes">Logout</a></li>
                    </ul>
                </nav>
               <p style="float: left; margin-left: 30px"><a href="index.php"><-Back</a></p>
				<!--
               <h2 style="float: left; margin-left: 30px"><a class="fancybox fancybox.ajax" id="playbtn" href="player.php?play=<?=$dirname?>"><-Play</a></h2>
               <h2 style="float: left; margin-left: 30px"><a href="newplayer.php?play=<?=$dirname?>">New Player</a></h2>-->
               <div style="float:right"><!--<img src="x" />--></div>
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">
                <h1>Project: <?=$dirname ?></h1>
            	<?php
					$dir = 'D:/wamp/www/Dropbox/Project323/'.$dirname;
					if ($handle = opendir($dir)) {
					    $blacklist = array('.', '..', '.dropbox', 'desktop.ini', 'links.config');
					    while (false !== ($file = readdir($handle))) {
					        if (!in_array($file, $blacklist) && endswith($file, '.png')) { ?>
					            <div class="uploadedimg">
					            	<a class="fancybox fancybox.ajax" href="editor.php?edit=<?=$dirname.'/'.$file?>">
					            		<img src="getimg.php?src=<?=$dirname.'/'.$file?>" filename="<?=$file?>" />
					            	</a>
					            	<!--<div><?=$file?></div>-->
					            </div>
					        <?php }
					    }
					    closedir($handle);
					}
				
				?>
            </div> <!-- #main -->
        </div> <!-- #main-container -->
<!--
        <div class="footer-container">
            <footer class="wrapper">
                <h3></h3>
            </footer>
        </div>
-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

		<script type="text/javascript" src="js/fancybox/jquery.fancybox.js?v=2.1.4"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>

        <script src="js/main.js"></script>

        <script>
			
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
