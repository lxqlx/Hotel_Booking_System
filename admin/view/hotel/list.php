<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>

<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Hotels On Our System</div>

  <!-- Table -->
<?php
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');

	$hotel= oci_parse($conn, "select * from Hotel order by name");
	
	oci_execute($hotel, OCI_DEFAULT);
	
	//table
	print '<table class="table">
				<tr>
					<td>#</td>
					<td>Name</td>
					<td>Rating</td>
					<td>Facility</td>
					<td>Phone No.</td>
					<td>Address</td>
				</tr>
	';
	$num=0;
	while($row1=oci_fetch_array($hotel)){
		$num++;
		echo 		"<tr>";
		echo		"<td>".$num."</td>";
		echo		"<td>".$row1[NAME]."</td>";
		echo		"<td>".$row1[RATING]."</td>";
		echo		"<td>".$row1[FACILITY]."</td>";
		echo		"<td>".$row1[PHONE_NO]."</td>";
		echo		"<td>".$row1[ADDRESS]."</td>";
		echo		"</tr>";
	}
	
	echo '</table>';
	oci_commit($conn);
	oci_close($conn);
?>

</div>
<script>
	$("#tab0").on('click',function(){event.preventDefault();$("#tab-content").load("view/dashboard.php");});
</script>