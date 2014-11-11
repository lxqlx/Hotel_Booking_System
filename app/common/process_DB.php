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
                    <a class="navbar-brand" href="../../index.php">Hotel Booking</a>
                  </div>
                  <div class="navbar-collapse collapse">
                    <form action="index.php" class="navbar-form navbar-right" role="form" method="post">';
        print "<a href=\"../user_profile/index.php\"> ".$result."</a>";
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
                    <a class="navbar-brand" href="../../index.php">Hotel Booking</a>
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
                      <a href="../sign_up/index.php"><span class="glyphicon glyphicon-user"></span> Sign up</a>
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
		oci_close($conn);
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
	$select= oci_parse($conn, "select AVG(price) as newprice from RoomType where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType'");
	oci_execute($select, OCI_DEFAULT);
	if ($row = oci_fetch_array($select)){
		oci_close($conn);
		return $row[NEWPRICE];
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return 180;
}

function printBookingHistory($UserEmail){
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	$today = date("m/d/Y");
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select hotel_name,hotel_address, room_type ,AVG(total_price) as newprice,AVG(quantity) as quant, min(room_date) as startDate,max(room_date) as endDate
	 from Booking where email='$UserEmail' group by hotel_name, hotel_address, room_type, quantity, booking_id
	 having min(room_date) < to_date('$today','MM/DD/YYYY') order by startDate ASC");

	oci_execute($select, OCI_DEFAULT);

	$colors = array(0 => 'active',1 => 'success',2 => 'warning');
    $index = 0;

	while ($row = oci_fetch_array($select)){
		$hname = $row[HOTEL_NAME];
		$haddr = $row[HOTEL_ADDRESS];
		$rtype = $row[ROOM_TYPE];
		$tprice = $row[NEWPRICE];
		$tquant = $row[QUANT];
		$sdate = date_format(date_create($row[STARTDATE]),'m/d/Y');
		$edate = date_format(date_create($row[ENDDATE]),'m/d/Y');
		$color = $colors[$index];
		$abbr = explode(" ", $haddr);
		$abbr = $abbr[0]."/".$abbr[1];
		print "
		<tr class='$color'>
	        <td>$hname</td>
	        <td><abbr title='$haddr'>$abbr</abbr></td>
	        <td>$rtype</td>
	        <td>$tprice</td>
	        <td>$tquant</td>
	        <td>$sdate</td>
	        <td>$edate</td>
	        <td></td>
	        <td></td>
	    </tr>
		";
		$index = ($index+1)%3;
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return;
}

function printBookingCurrent($UserEmail){
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	$today = date("m/d/Y");
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select hotel_name,hotel_address, room_type ,AVG(total_price) as newprice, AVG(quantity) as quant, min(room_date) as startDate,max(room_date) as endDate
	 from Booking where email='$UserEmail' group by hotel_name, hotel_address, room_type, booking_id
	 having min(room_date) >= to_date('$today','MM/DD/YYYY') order by startDate ASC");
	oci_execute($select, OCI_DEFAULT);
	$colors = array(0 => 'active',1 => 'success',2 => 'warning');
    $index = 0;

	while ($row = oci_fetch_array($select)){
		$hname = $row[HOTEL_NAME];
		$haddr = $row[HOTEL_ADDRESS];
		$rtype = $row[ROOM_TYPE];
		$tprice = $row[NEWPRICE];
		$tquant = $row[QUANT];
		$sdate = date_format(date_create($row[STARTDATE]),'m/d/Y');
		$edate = date_format(date_create($row[ENDDATE]),'m/d/Y');
		$color = $colors[$index];
		$abbr = explode(" ", $haddr);
		$abbr = $abbr[0]."/".$abbr[1];
		print "
		<tr class='$color'>
	        <td>$hname</td>
	        <td><abbr title='$haddr'>$abbr</abbr></td>
	        <td>$rtype</td>
	        <td>$tprice</td>
	        <td>$tquant</td>
	        <td>$sdate</td>
	        <td>$edate</td><form action='edit.php' class='form-signin' role='form' method='get'>
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-success' type='submit' name='Edit' value='Edit'>Edit</button></td>
			</form>
			<form action='index.php' class='form-signin' role='form' method='post'>
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-danger' type='submit' name='Delete' value='Delete'>Delete</button></td>
			</form>
		    
	    </tr>
		";
		$index = ($index+1)%3;
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return;
}


function insertBooking($userEmail,$hotelName, $hotelAddr, $roomType, $startDate, $endDate, $quantity, $total){
	$bookingID = sha1($startDate.$endDate);
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');

	$date = $startDate;
	$sth = oci_parse($conn, "alter session set NLS_DATE_FORMAT='MM/DD/YYYY'");
	$suc = oci_execute($sth, OCI_DEFAULT);
	
	while (strtotime($date) <= strtotime($endDate)) {
		//echo $date;
		$insert_str = "insert into Booking values ('$userEmail', '$bookingID','$hotelName', '$hotelAddr','$roomType','$date', $quantity,$total)";
		// insert
		$select_ry = "select quantity from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
		
		
		$sth2 = oci_parse($conn, $select_ry);
		$suc2 = oci_execute($sth2, OCI_DEFAULT);


		if ($row = oci_fetch_array($sth2)){
			$q= $row[QUANTITY];
			if ((int)$q < (int)$quantity) {
				printAlert("danger", "Room Not Enough!", "");
				oci_close($conn);
				return false;}
			$update_ry = "update roomtype set quantity=$q-$quantity where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
			$sth3 = oci_parse($conn, $update_ry);
			$suc3 = oci_execute($sth3, OCI_DEFAULT);
			if (!$suc3){
				printAlert("danger", "Room Type Update Error", "");
				oci_close($conn);
				return $suc3;
			} 
		}

		$sth = oci_parse($conn, $insert_str);
		$suc = oci_execute($sth, OCI_DEFAULT);

		if(!$suc) {
			printAlert("warning", "Booking already exits!Go to Modify!", "../user_profile/index.php");
			oci_close($conn);
			return $suc;
		}
		$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return true;
}

function deleteBooking($userEmail,$hotelName, $hotelAddr, $roomType, $roomQuant, $startDate, $endDate){
	$bookingID = sha1($startDate.$endDate);
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "delete from booking where email='$userEmail' and hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and booking_id='$bookingID'");
	$suc = oci_execute($select, OCI_DEFAULT);
	if($suc){
		$date = $startDate;
		while (strtotime($date) <= strtotime($endDate)) {
			$select_ry = "select quantity from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
			
			$sth2 = oci_parse($conn, $select_ry);
			$suc2 = oci_execute($sth2, OCI_DEFAULT);


			if ($row = oci_fetch_array($sth2)){
				$q= $row[QUANTITY];
				$update_ry = "update roomtype set quantity=$q+$roomQuant where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
				//echo $update_ry;
				$sth3 = oci_parse($conn, $update_ry);
				$suc3 = oci_execute($sth3, OCI_DEFAULT);
				if (!$suc3){
					oci_close($conn);
					return $suc3;
				} 
			}

			$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
		}

	}else {
		oci_close($conn);
		return $suc;
	}
	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return true;
}


function getRoomTypes($hotelName, $hotelAddr, $startDate, $endDate, $conn){
	//putenv('ORACLE_HOME=/oraclient');
	// connect
	$Tsql = "select room_type, AVG(price) as room_price, min(quantity) as room_quantity from RoomType where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_date>=to_date('$startDate','MM/DD/YYYY') and room_date<=to_date('$endDate','MM/DD/YYYY') group by room_type";
    //echo $Tsql;
    $Tselect= oci_parse($conn, $Tsql);
    //echo $Tsql;
	oci_execute($Tselect, OCI_DEFAULT);
	$roomArray = array();
	while ($Trow = oci_fetch_array($Tselect)) {
		$rType=$Trow[ROOM_TYPE];
		$rPrice=$Trow[ROOM_PRICE];
		$rQuantity=$Trow[ROOM_QUANTITY];
		//echo $rQuantity;
		$rTemp =array($rType, $rPrice, $rQuantity);
		array_push($roomArray, $rTemp);
	}
	//dont commit;
	// disconnect
	oci_close($conn);
	return $roomArray;
}


function fakeDeleteBooking($userEmail,$hotelName, $hotelAddr, $roomType, $roomQuant, $startDate, $endDate){
	$bookingID = sha1($startDate.$endDate);
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "delete from booking where email='$userEmail' and hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and booking_id='$bookingID'");
	$suc = oci_execute($select, OCI_DEFAULT);
	if($suc){
		$date = $startDate;
		while (strtotime($date) <= strtotime($endDate)) {
			$select_ry = "select quantity from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
			//echo $select_ry;
			//echo "<hr>";
			$sth2 = oci_parse($conn, $select_ry);
			$suc2 = oci_execute($sth2, OCI_DEFAULT);


			if ($row = oci_fetch_array($sth2)){
				$q= $row[QUANTITY];
				$update_ry = "update roomtype set quantity=$q+$roomQuant where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
				//echo $update_ry;
				//echo "<hr>";
				$sth3 = oci_parse($conn, $update_ry);
				$suc3 = oci_execute($sth3, OCI_DEFAULT);
				if (!$suc3){
					oci_close($conn);
					return $suc3;
				} 
			}

			$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
		}

	}else {
		oci_close($conn);
		return $suc;
	}

	//oci_commit($conn);
	//dont commit;
	// disconnect
	//oci_close($conn);
	//return $roomArray;
	return $conn;
}

function fakeInsertBooking($userEmail,$hotelName, $hotelAddr, $roomType, $startDate, $endDate, $quantity, $total, $conn){
	$bookingID = sha1($startDate.$endDate);
	putenv('ORACLE_HOME=/oraclient');
	$date = $startDate;
	$sth = oci_parse($conn, "alter session set NLS_DATE_FORMAT='MM/DD/YYYY'");
	$suc = oci_execute($sth, OCI_DEFAULT);
	
	while (strtotime($date) <= strtotime($endDate)) {
		//echo $date;
		$insert_str = "insert into Booking values ('$userEmail', '$bookingID','$hotelName', '$hotelAddr','$roomType','$date', $quantity,$total)";
		// insert
		$select_ry = "select quantity from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";		
		
		$sth2 = oci_parse($conn, $select_ry);
		$suc2 = oci_execute($sth2, OCI_DEFAULT);


		if ($row = oci_fetch_array($sth2)){
			$q= $row[QUANTITY];
			if ((int)$q < (int)$quantity) {
				printAlert("danger", "Room Not Enough!", "");
				oci_close($conn);
				return false;}
			$update_ry = "update roomtype set quantity=$q-$quantity where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
			$sth3 = oci_parse($conn, $update_ry);
			$suc3 = oci_execute($sth3, OCI_DEFAULT);
			if (!$suc3){
				printAlert("danger", "Room Type Update Error", "");
				oci_close($conn);
				return $suc3;
			} 
		}

		$sth = oci_parse($conn, $insert_str);
		$suc = oci_execute($sth, OCI_DEFAULT);

		if(!$suc) {
			printAlert("warning", "Booking already exits!Go to Modify!", "index.php");
			oci_close($conn);
			return $suc;
		}
		$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return true;
}

function editBooking($userEmail,$hotelName, $hotelAddr, $roomType, $startDate, $endDate, $quantity, $total){
	$bookingID = sha1($startDate.$endDate);
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');

	$date = $startDate;
	$sth = oci_parse($conn, "alter session set NLS_DATE_FORMAT='MM/DD/YYYY'");
	$suc = oci_execute($sth, OCI_DEFAULT);
	
	while (strtotime($date) <= strtotime($endDate)) {
		//echo $date;
		$insert_str = "insert into Booking values ('$userEmail', '$bookingID','$hotelName', '$hotelAddr','$roomType','$date', $quantity,$total)";
		// insert
		$select_ry = "select quantity from roomtype where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
		
		
		$sth2 = oci_parse($conn, $select_ry);
		$suc2 = oci_execute($sth2, OCI_DEFAULT);


		if ($row = oci_fetch_array($sth2)){
			$q= $row[QUANTITY];
			if ((int)$q < (int)$quantity) {
				printAlert("danger", "Room Not Enough!", "");
				oci_close($conn);
				return false;}
			$update_ry = "update roomtype set quantity=$q-$quantity where hotel_name='$hotelName' and hotel_address='$hotelAddr' and room_type='$roomType' and room_date=to_date('$date','MM/DD/YYYY')";
			$sth3 = oci_parse($conn, $update_ry);
			$suc3 = oci_execute($sth3, OCI_DEFAULT);
			if (!$suc3){
				printAlert("danger", "Room Type Update Error", "");
				oci_close($conn);
				return $suc3;
			} 
		}

		$sth = oci_parse($conn, $insert_str);
		$suc = oci_execute($sth, OCI_DEFAULT);

		if(!$suc) {
			printAlert("warning", "Booking already exits!Go to Modify!", "../user_profile/index.php");
			oci_close($conn);
			return $suc;
		}
		$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return true;
}


function getUsers(){
	$userArray = array();
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');

	$select= oci_parse($conn, "select email,name from Customer");
    oci_execute($select, OCI_DEFAULT);
    while ($row = oci_fetch_array($select)) {
      $email=$row[EMAIL];
      $name=$row[NAME];
      $value = $email.":".$name;
      array_push($userArray, $value);
  	}

	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return $userArray;
}

function adminPrintBookingHistory(){
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	$today = date("m/d/Y");
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select email, hotel_name,hotel_address, room_type ,AVG(total_price) as newprice,AVG(quantity) as quant, min(room_date) as startDate,max(room_date) as endDate
	 from Booking group by email, hotel_name, hotel_address, room_type, quantity, booking_id
	 having min(room_date) < to_date('$today','MM/DD/YYYY') order by startDate ASC");

	oci_execute($select, OCI_DEFAULT);

	$colors = array(0 => 'active',1 => 'success',2 => 'warning');
    $index = 0;

	while ($row = oci_fetch_array($select)){
		$uemail = $row[EMAIL];
		$hname = $row[HOTEL_NAME];
		$haddr = $row[HOTEL_ADDRESS];
		$rtype = $row[ROOM_TYPE];
		$tprice = $row[NEWPRICE];
		$tquant = $row[QUANT];
		$sdate = date_format(date_create($row[STARTDATE]),'m/d/Y');
		$edate = date_format(date_create($row[ENDDATE]),'m/d/Y');
		$color = $colors[$index];
		$abbr = explode(" ", $haddr);
		$abbr = $abbr[0]."/".$abbr[1];
		print "
		<tr class='$color'>
	        <td>$uemail</td>
	        <td>$hname</td>
	        <td><abbr title='$haddr'>$abbr</abbr></td>
	        <td>$rtype</td>
	        <td>$tprice</td>
	        <td>$tquant</td>
	        <td>$sdate</td>
	        <td>$edate</td>
	        <form action='edit.php' class='form-signin' role='form' method='get'>
				<input type='hidden' name='UserEmail' value='$uemail' />
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-success' type='submit' name='Edit' value='Edit'>Edit</button></td>
			</form>
			<form action='index.php' class='form-signin' role='form' method='post'>
				<input type='hidden' name='UserEmail' value='$uemail' />
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-danger' type='submit' name='Delete' value='Delete'>Delete</button></td>
			</form>
	    </tr>
		";
		$index = ($index+1)%3;
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return;
}

function adminPrintBookingCurrent(){
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	$today = date("m/d/Y");
	//echo "select name from Customer where email='$email' and password='$password'";
	$select= oci_parse($conn, "select email,hotel_name,hotel_address, room_type ,AVG(total_price) as newprice, AVG(quantity) as quant, min(room_date) as startDate,max(room_date) as endDate
	 from Booking group by email, hotel_name, hotel_address, room_type, booking_id
	 having min(room_date) >= to_date('$today','MM/DD/YYYY') order by startDate ASC");
	oci_execute($select, OCI_DEFAULT);
	$colors = array(0 => 'active',1 => 'success',2 => 'warning');
    $index = 0;

	while ($row = oci_fetch_array($select)){
		$uemail = $row[EMAIL];
		$hname = $row[HOTEL_NAME];
		$haddr = $row[HOTEL_ADDRESS];
		$rtype = $row[ROOM_TYPE];
		$tprice = $row[NEWPRICE];
		$tquant = $row[QUANT];
		$sdate = date_format(date_create($row[STARTDATE]),'m/d/Y');
		$edate = date_format(date_create($row[ENDDATE]),'m/d/Y');
		$color = $colors[$index];
		$abbr = explode(" ", $haddr);
		$abbr = $abbr[0]."/".$abbr[1];
		print "
		<tr class='$color'>
	        <td>$uemail</td>
	        <td>$hname</td>
	        <td><abbr title='$haddr'>$abbr</abbr></td>
	        <td>$rtype</td>
	        <td>$tprice</td>
	        <td>$tquant</td>
	        <td>$sdate</td>
	        <td>$edate</td>
	        <form action='edit.php' class='form-signin' role='form' method='get'>
				<input type='hidden' name='UserEmail' value='$uemail' />
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-success' type='submit' name='Edit' value='Edit'>Edit</button></td>
			</form>
			<form action='index.php' class='form-signin' role='form' method='post'>
				<input type='hidden' name='UserEmail' value='$uemail' />
				<input type='hidden' name='HotelName' value='$hname' />
				<input type='hidden' name='HotelAddr' value='$haddr' />
				<input type='hidden' name='RoomType' value='$rtype' />
				<input type='hidden' name='RoomQuant' value='$tquant' />
				<input type='hidden' name='StartDate' value='$sdate' />
	      		<input type='hidden' name='EndDate' value='$edate' />
				<td><button class='btn btn-danger' type='submit' name='Delete' value='Delete'>Delete</button></td>
			</form>
		    
	    </tr>
		";
		$index = ($index+1)%3;
	}

	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return;
}
?>
