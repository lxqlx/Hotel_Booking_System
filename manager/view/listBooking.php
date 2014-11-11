<?php
	session_start();
	if($_SESSION["role"]!="manager")
	echo "<script>location.href='login.php'</script>";
?>

<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Customer Bookings</div>

  <!-- Table -->
<?php
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	
	$hotel_name = $_SESSION["hotel_name"];
	$hotel_address = $_SESSION["hotel_address"];
	
	$select1= oci_parse($conn, "select * from Booking where hotel_name='$hotel_name' and hotel_address='$hotel_address' order by booking_id");
	oci_execute($select1, OCI_DEFAULT);
	
	//table
	
	print '<table class="table">
				<tr>
					<td>#</td>
					<td>Name</td>
					<td>Email</td>
					<td>Hotel</td>
					<td>Check-in Date</td>
					<td>Room Type</td>
					<td>Quantity</td>
					<td>Price</td>
					<td>Hotel Addr</td>
				</tr>
	';
	$num=0;
	while($row1=oci_fetch_array($select1)){
		$num++;
		$select2= oci_parse($conn, "select name from Customer where email='$row1[EMAIL]'");
		oci_execute($select2, OCI_DEFAULT);
		$name=oci_fetch_array($select2);
	
		echo 		"<tr>";
		echo		"<td>".$num."</td>";
		echo		"<td>".$name[0]."</td>";
		echo		"<td>".$row1[EMAIL]."</td>";
		echo		"<td>".$row1[HOTEL_NAME]."</td>";
		echo		"<td>".$row1[ROOM_DATE]."</td>";
		echo		"<td>".$row1[ROOM_TYPE]."</td>";
		echo		"<td>".$row1[QUANTITY]."</td>";
		echo		"<td>".$row1[TOTAL_PRICE]."</td>";
		echo		"<td>".$row1[HOTEL_ADDRESS]."</td>";
		echo		"</tr>";
	}
	
	echo '</table>';
	oci_commit($conn);
	oci_close($conn);
?>

</div>
