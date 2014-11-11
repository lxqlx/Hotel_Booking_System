<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Search Booking</div>

  <!-- Table -->
  <div class="panel-body">
			<div class="container" style="max-width:400px;">
			<form action="" method="post" >
                    <div class="form-group">
					<label>Customer Email:</label>
                      <input type="email"  class="form-control" name="email" required/>
                    </div>
					<div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" >Search Customer Booking</button>
					</div>
			</form>
			</div>
<?php


	if(isset($_POST["email"])){
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	$email=$_POST["email"];
	
	$select1= oci_parse($conn, "select * from Booking where email='$email' order by email ");
	
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
	} 
?>
	</div>
</div>