<?php 
session_start();
if($_SESSION["role"]!="admin")
	echo "<script>location.href='view/login.php'</script>";
else
	echo "<script>location.href='../app/admin/index.php'</script>";
?>
<!DOCTYPE html>
<html>
<head>

<title>Admin System</title>

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
            <a class="navbar-brand" href="admin.php" style="font-family:serif;">Admin System</a>
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
	
		<div class="panel panel-primary tabbable" style="width:20%;float:left;">
		<div class="panel-heading"><a href="?dashboard" style="color:white;align:middle;" >Dashboard</a></div>
		<div class="panel-body">
		<ul class="nav nav-pills nav-stacked" role="tablist">

		<li role="presentation" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">User<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="?func=listUsers"  >List Users</a></li>
					<li><a href="?func=SearchUser" >Search User</a></li>
					<li><a href="?func=AddCustomer" >Add Customer</a></li>
					<li><a href="?func=AddHotelManager" >Add Hotel Manger</a></li>
					<li><a href="?func=AddSystemAdmin" >Add System Admin</a></li>
				</ul>
		</li>
		<li role="presentation" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Hotels<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="?func=listHotels" >List Hotels</a></li>
					<li><a href="?func=SearchHotel" >Search Hotel</a></li>
					<li><a href="?func=AddHotel" >Add Hotel</a></li>
				</ul>
		</li>
		<li role="presentation" class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">Bookings<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="?func=ListBookings" >List Bookings</a></li>
					<li><a href="?func=SearchBooking" >Search Booking</a></li>
				</ul>
		</li>
	
		</ul>
		</div>
		</div>
		<div id="tab-content"  class="container"style="width:80%;float:left;">
			<?php 
			
			$function=$_GET["func"];
			if(isset($_GET["dashboard"])||$function=="")	require 'view/dashboard.php';
			if($function=="listUsers") require 'view/user/list.php';
			if($function=="SearchUser") require 'view/user/search.php';
			if($function=="AddCustomer") require 'view/user/addCustomer.php';
			if($function=="AddHotelManager") require 'view/user/addHotelManager.php';
			if($function=="AddSystemAdmin") require 'view/user/addSystemAdmin.php';
			if($function=="listHotels") require 'view/hotel/list.php';
			if($function=="SearchHotel") require 'view/hotel/search.php';
			if($function=="AddHotel") require 'view/hotel/add.php';
			if($function=="ListBookings") require 'view/booking/list.php';
			if($function=="SearchBooking") require 'view/booking/search.php';
			?>
		</div>
	</div>
</div>
</body>

</html>