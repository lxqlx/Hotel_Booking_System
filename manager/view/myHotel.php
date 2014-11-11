<?php
	session_start();
	if($_SESSION["role"]!="manager")
	echo "<script>location.href='login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">My Hotel</div>

  <!-- Table -->
  <div class="panel-body">
		<div class="container" style="max-width:400px;margin-left:10px;">

<?php
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	$email=$_SESSION["email"];
	$hotel_name = $_SESSION["hotel_name"];
	$hotel_address = $_SESSION["hotel_address"];
	$select1= oci_parse($conn, "select * from Hotel where name='$hotel_name' and address='$hotel_address'");
	
	oci_execute($select1, OCI_DEFAULT);
	$row1=oci_fetch_array($select1);
	
	echo "My Hotel : ".$hotel_name."  (".$row1[RATING]." star hotel)<br>";
	echo "Available Facilities: ".$row[FACILITY]."<br>";
	echo "Contact Number: ".$row1[PHONE_NO]."<br>";
	echo "Mail Address: ".$hotel_address."";
	oci_commit($conn);
	oci_close($conn);
?>
		</div>
	</div>
</div>