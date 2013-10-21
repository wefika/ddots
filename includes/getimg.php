<?php

include "Dotenv.php";
Dotenv::load(dirname(__DIR__));


if(isset($_GET['src'])) {

	$src = $_GET['src'];

	$im = file_get_contents($_ENV['DDOTS_DIR'].'/'.$src);
	header('content-type: image/png');
	echo $im;

}

?>