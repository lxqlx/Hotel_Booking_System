<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Search Hotel</div>

  <!-- Table -->
  <div class="panel-body">
			<div class="container" style="max-width:400px;">
			<form action="" method="post" >
                    <div class="form-group">
					<label>Hotel Name:</label>
                      <input type="text"  class="form-control" name="name"/>
                    </div>
					<div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" >Search</button>
					</div>
			</form>
			</div>
<?php


	if(isset($_POST["name"])){
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	$name=$_POST["name"];
	
	$search= oci_parse($conn, "select * from Hotel where name='$name'");
	
	oci_execute($search, OCI_DEFAULT);

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
	while($row1=oci_fetch_array($search)){
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
	} 
?>
	</div>
</div>