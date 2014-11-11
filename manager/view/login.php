<?php
session_start();
if($_SESSION["role"]=="manager")
	echo "<script >location.href='../manager.php'</script>";
else{
	session_destroy();
	session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Hotel Manager System</title>
 
 <!-- Bootstrap core CSS -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet">

	<!-- date picker -->
    <link href="../../public/css/datepicker.css" rel="stylesheet">

</head>
<body>
	<nav class="navbar  narbar-default" role="navigation" style="background-color:#BCD9F5;">
         <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#" style="font-family:serif;">Hotel Manager System</a>
        </div>
		</div>
        
	</nav>
	<br>
				<div class="container" style="max-width:300px;padding-top:10px;">
					<div id="result"></div><br>
                  <form action="../control/checkLogin.php" method="post" >
                    <div class="form-group">
					<label>Your email</label><br>
                      <input type="email"  class="form-control" name="email"/>
                    </div>
					<div class="form-group">
					<label>Password</label><br>
                      <input type="password" class="form-control" name="password"/>
                    </div>
					<div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" >Sign in</button>
					</div>
				  </form>
                </div>
   

              <div class="footer" style="padding-top:100px;">
                <p>&copy; Company 2014</p>
              </div>
			  

</body>
</html>