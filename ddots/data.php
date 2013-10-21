<?php

if(isset($_GET['saveConection'])) {
	
	$project = $_POST['project'];
	$data = $_POST['data'];
	
	file_put_contents('D:/wamp/www/Dropbox/Project323/'.$project.'/links.config', $data."\n", FILE_APPEND | LOCK_EX);
	
	echo "done";
}

if(isset($_GET['connections'])) {
		
	$project = $_POST['project'];
	
	$toBeRestored = file_get_contents('D:/wamp/www/Dropbox/Project323/'.$project.'/links.config');
	$data = unserialize($toBeRestored);
	echo $data;
}

if(isset($_GET['getImages'])) {
	
	$project = $_POST['project'];
	
	$dir = 'D:/wamp/www/Dropbox/Project323/'.$project;
	echo "<ul>";
	if ($handle = opendir($dir)) {
	    $blacklist = array('.', '..', '.dropbox', 'desktop.ini', 'links.config');
	    while (false !== ($file = readdir($handle))) {
	        if (!in_array($file, $blacklist)) { ?>
	            	<li><img src="getimg.php?src=<?=$project.'/'.$file?>" /></li>
	            
	        <?php }
	    }
	    closedir($handle);
	}
	echo "</ul>";
}

if(isset($_GET['logout'])) {
	session_start();
	$_SESSION['login'] = false;
	header("location: login.php");
}

?>

