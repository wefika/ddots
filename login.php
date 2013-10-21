<?php

	session_start();
	$error = false;
	if(isset($_SESSION['login']) && $_SESSION['login'] == true) {
		header('location: index.php');
	}

	include('includes/mysql_connect.php');

	if(isset($_POST['loginsubmit'])) {
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$query = mysql_query("SELECT * FROM user WHERE email='$email' AND password='$pass'") or die(mysql_error());

		if(mysql_num_rows($query) > 0) {
			$row = mysql_fetch_assoc($query);
			$_SESSION['login'] = true;
			$_SESSION['loginid'] = $row['id'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['name'] = $row['name'];
			header('location: index.php');
		} else {
			$error = true;
		}

	}

?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>FirstBunch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      h2 {
      	text-align: center;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="http://twitter.github.io/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet">


    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="http://twitter.github.io/bootstrap/assets/ico/favicon.png">
  <style type="text/css"></style><script type="text/javascript" id="__bmn_injectSubmitHookFn__">function __bmn_injectSubmitHook__() {
		Array.prototype.forEach.call(arguments, function(i) {
			var form = document.forms[i], submitFunction = form.submit;
			if (!submitFunction || (typeof (submitFunction) == "function" && submitFunction.name != "__bmn_submitHook__")) {
				form.submit = function __bmn_submitHook__() {
					var submitEvent = document.createEvent('Event');
					submitEvent.initEvent('submit', true, true);
					form.dispatchEvent(submitEvent);
					return submitFunction ? submitFunction.call(form) : true;
				};
			}
		});
	}</script></head>

  <body>

    <div class="container">
      <h2>Bunch<br/><small>FirstBunch v1.0 + ddots v1.0</small></h2>
      <form class="form-signin" action="login.php" method="POST">
        <h4 class="form-signin-heading">Please sign in</h4>
        <span><?=($error ? "<label class='label label-important'>Incorrect login!</label>" : "")?></span>
        <input type="text" class="input-block-level" placeholder="Email address" name="email">
        <input type="password" class="input-block-level" placeholder="Password" name="pass">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <input class="btn btn-primary" type="submit" value="Sign in" name="loginsubmit" />
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

</body></html>