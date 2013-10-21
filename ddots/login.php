<?php
	session_start();

	if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
		header("location: index.php");
	}
	
	if(isset($_POST['passSubmit'])) {
		if($_POST['pass'] == "bunch123") {
			$_SESSION['login'] = true;
			header("location: index.php"); 
		}
	}


?><!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>ddots v1.0</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/normalize.min.css">
        <link rel="stylesheet" href="css/main.css">

    </head>
    <body>
        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">ddots v1.0</h1>
                <!--
                <nav>
                    <ul>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                        <li><a href="#">nav ul li a</a></li>
                    </ul>
                </nav>-->
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">
            	
			<article>
				<h2>Login</h2>
				
				<form action="login.php" method="post">
					Please provide password to continue:<br /> 
					<input type="password" name="pass" /><br />
					<input type="submit" value="Potrdi" name="passSubmit" />
				</form>
			</article>
				


            </div> <!-- #main -->
        </div> <!-- #main-container -->

    </body>
</html>
