<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Hotel Booking Sign Up</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sign_up.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
	<?php
		ob_start();
		include('process_DB.php');

		if(!empty($_POST['UserName'])){
			$result = insertCustomer();
			if(!$result)
				print "<div class=\"alert alert-danger\" role=\"alert\"> <p class=\"text-center\">Email Already Registered!</p></div>";
			else{
				print "<div class=\"alert alert-success\" role=\"alert\">";
				print "  <a href=\"index.php\" class=\"alert-link\"> <p class=\"text-center\">Successful! Go to main page!</p></a>";
				print " </div>";
			}
		}
	?>

      <form action="sign_up.php" class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Please sign up</h2>
        <input type="text" name="UserName" class="form-control" placeholder="Name" required autofocus>
        <input type="email" name="UserEmail" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="UserPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

