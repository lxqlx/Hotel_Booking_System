<?php
ob_start();
date_default_timezone_set("Asia/Singapore");
function printNavbar($result){
	if($result){
		print
            '
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Hotel Booking</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form action="index.php" class="navbar-form navbar-right" role="form" method="post">';
        print "<a href=\"app/user_profile/index.php\"> ".$result."</a>";
        print
				    '<a>&nbsp;</a>
				    <button name="logOut" value="out" class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-log-out"></span> Log Out</button>
				    </form>
				  </div><!--/.navbar-collapse -->
				</div>
			</nav>

			<div class="jumbotron">
			';
	}
	else{
		print '
              <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Hotel Booking</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form action="index.php" class="navbar-form navbar-right" role="form" method="post">
                      <div class="form-group">
                        <input type="email" name="SignInEmail" placeholder="Email" class="form-control" required>
                      </div>
                      <div class="form-group">
                        <input type="password" name="SignInPassword" placeholder="Password" class="form-control" required>
                      </div>
                      <button type="submit" class="btn btn-success">Sign in</button>
                      <a href="app/sign_up/index.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
                    </form>
                  </div><!--/.navbar-collapse -->
                </div>
              </nav>

              <div class="jumbotron">
			';
	}
}
function printAlert($type, $content, $link){
	print
	"
	<div class=\"container\">
      <div class=\"alert alert-$type\" role=\"alert\">
        <a href=\"$link\" class=\"alert-link\"> <p class=\"text-center\">$content</p></a>
      </div>
    </div>
    ";
}
function selectCustomer(){
	putenv('ORACLE_HOME=/oraclient');
	$email = $_POST['SignInEmail'];
	$password = sha1($_POST['SignInPassword']);
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select name from Customer where email='$email' and password='$password'");
	oci_execute($select, OCI_DEFAULT);
	if ($row = oci_fetch_array($select)){
		return $row[NAME];
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return False;
}
function insertCustomer()
{
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');


	$Name = $_POST['UserName'];
	$email = $_POST['UserEmail'];
	$password = sha1($_POST['UserPassword']);
	//check if exists
	$select= oci_parse($conn, "select name from Customer where email='$email' and password='$password'");
	oci_execute($select, OCI_DEFAULT);
	if ($row = oci_fetch_array($select)){
		oci_commit($conn);
		oci_close($conn);
		return false;
	}
	//echo 'Name        : '.$Name.'<br/>';
	//echo 'Email Address    : '.$email.'<br/>';
	//echo 'Password         : '.$password.'<br/>';
	$insert_str = "insert into Customer values ('$email', '$Name', '$password')";
	//echo $insert_str;

	// insert
	$sth = oci_parse($conn, $insert_str);
	$suc = oci_execute($sth, OCI_DEFAULT);
	//if ($suc)
	//	//echo "<p>Successfully added an Customer.</p>";
	//	header('Location: index.php');
	//else{
	//	//echo "<p>Error adding an Customer.</p>";
	//	header('Location: sign_up.php');
	//}

	// select
	//$sth = oci_parse($conn, "select email, name, password from Customer");
	//oci_execute($sth, OCI_DEFAULT);
	//while ($row = oci_fetch_array($sth)) {
	//echo "<p>Email = ", $row[EMAIL], ", Name = ", $row[NAME],", Password_hash = ", $row[PASSWORD], "</p>\n";
	//}
	
	// delete
	//$sth = oci_parse($conn, "delete from Customer");
	//if (oci_execute($sth, OCI_DEFAULT))
	//echo "<p>Successfully deleted all Customers.</p>";
	//else echo "<p>Error deleting Customers.</p>";
	
	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return $suc;
}

function getPrice($hotelName, $hotelAddr, $roomType){
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select AVG(price) as price from RoomType where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$room_type'");
	oci_execute($select, OCI_DEFAULT);
	if ($row = oci_fetch_array($select)){
		return $row[PRICE];
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return 180;
}

?>
