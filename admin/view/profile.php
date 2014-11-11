<?php
session_start();
if($_SESSION["role"]!="admin")
	echo "<script>location.href='login.php'</script>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin System</title>
 
 <!-- Bootstrap core CSS -->
    <link href="../../public/css/bootstrap.min.css" rel="stylesheet">

	<!-- date picker -->
    <link href="../../public/css/datepicker.css" rel="stylesheet">

</head>
<body>

	<nav class="navbar  narbar-default" role="navigation" style="background-color:#BCD9F5;">
        <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="../admin.php" style="font-family:serif;">Admin System</a>
        </div>
			<div class="navbar-collapse">
		
		<form action="../control/logout.php" class="navbar-form navbar-right" role="form" method="post">
			<a href="profile.php"><?php echo $_SESSION["name"];?></a>&nbsp;&nbsp;
			<button name="logout" type="submit" class="btn btn-primary btn-sm">Logout</button>
		</form>
		</div>
		</div>
        
	</nav>
	<br>
	<div class="container" style="max-width:600px;">
		
		<div class="panel panel-info" style="vertical-align:middle;">
			<div class="panel-heading">My Profile</div>
			<div class="panel-body" style="min-height:400px;">
			<?php 
				$name=$_SESSION["name"];
				$email=$_SESSION["email"];
				echo "My Name :  ".$name."<br>";
				echo "System role :  Admin User<br>";
				echo "Email :  ".$email." <p style='color:red;'>email is used for identification and cannot be changed.</p>";
			?>
			</div>
		</div>
		
   </div>

              <div class="footer" style="padding-top:100px;">
                <p>&copy; Company 2014</p>
              </div>
			  

</body>
</html>