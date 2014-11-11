<?php 
session_start();
if($_SESSION["role"]!="manager")
	echo "<script>location.href='view/login.php'</script>";
?>
<!DOCTYPE html>
<html>
<head>

<title>Hotel Manager System</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="../public/js/dropdown.js"></script>
</head>
<body>

	<nav class="navbar  narbar-inverse" role="navigation" style="background-color:#BCD9F5;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="manager.php" style="font-family:serif;">Hotel Manager System</a>
        </div>
		<div class="navbar-collapse">
		
		<form action="control/logout.php" class="navbar-form navbar-right" role="form" method="post">
			<a href="view/profile.php"><?php echo $_SESSION["name"];?></a>&nbsp;&nbsp;
			<button name="logout" type="submit" class="btn btn-primary btn-sm">Logout</button>
		</form>

		</div>
	</div>
	</nav>
	
	<!-- Single button -->
	<div class="container" style="width:100%;">
	
		<div class="panel panel-primary" style="width:20%;float:left;">
		<div class="panel-heading"><a href="?dashboard" style="color:white;align:middle;" >Dashboard</a></div>
		<div class="panel-body">
		<ul class="nav nav-pills nav-stacked" role="tablist">
					<li><a href="?func=listBookings"  >List Bookings</a></li>
					<li><a href="?func=searchBooking" >Search Bookins</a></li>
					<li><a href="?func=viewHotel" >View My Hotel</a></li>
		</ul>
		</div>
		</div>
		<div id="tab-content"  class="container"style="width:80%;float:left;">
			<?php 
			
			$function=$_GET["func"];
			if(isset($_GET["dashboard"])||$function=="")	require 'view/dashboard.php';
			if($function=="listBookings") require 'view/listBooking.php';
			if($function=="searchBooking") require 'view/searchBooking.php';
			if($function=="viewHotel") require 'view/myHotel.php';			
			?>
		</div>
	</div>
</div>
</body>

</html>