<?php 

$dir = 'D:/wamp/www/Dropbox/Project323/';

if(isset($_GET['src'])) {
	
	$src = $_GET['src'];
	
	$im = file_get_contents($dir.'/'.$src); 
	header('content-type: image/png'); 
	echo $im; 
	
}

?>