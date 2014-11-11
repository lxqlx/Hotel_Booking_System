<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Search User</div>

  <!-- Table -->
  <div class="panel-body">
			<div class="container" style="max-width:400px;">
			<form action="" method="post" >
                    <div class="form-group">
					<label>User Name:</label>
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
	$admin= oci_parse($conn, "select name,email from admin where name='$name'");
	$manager= oci_parse($conn, "select name,email, hotel_name,hotel_address from Manager where name='$name'");
	$customer= oci_parse($conn, "select name, email from Customer where name='$name'");
	
	oci_execute($admin, OCI_DEFAULT);
	oci_execute($manager, OCI_DEFAULT);
	oci_execute($customer, OCI_DEFAULT);
	
	//table
	print '<table class="table">
				<tr>
					<td>#</td>
					<td>Name</td>
					<td>Email</td>
					<td>Hotel Name</td>
				
					<td>System Role</td>
				</tr>
	';
	$num=0;
	while($row1=oci_fetch_array($admin)){
		$num++;
		echo 		"<tr>";
		echo		"<td>".$num."</td>";
		echo		"<td>".$row1[NAME]."</td>";
		echo		"<td>".$row1[EMAIL]."</td>";
		echo		"<td>--</td>";
		//echo		"<td>--</td>";
		echo		"<td>admin user</td>";
		echo		"</tr>";
	}
	while($row2=oci_fetch_array($manager)){
		$num++;
		echo 		"<tr>";
		echo		"<td>".$num."</td>";
		echo		"<td>".$row2[NAME]."</td>";
		echo		"<td>".$row2[EMAIL]."</td>";
		echo		"<td>".$row2[HOTEL_NAME]."</td>";
		//echo		"<td>".$row2[HOTEL_ADDRESS]."</td>";
		echo		"<td>hotel manager</td>";
		echo		"</tr>";
	}
	while($row3=oci_fetch_array($customer)){
		$num++;
		echo 		"<tr>";
		echo		"<td>".$num."</td>";
		echo		"<td>".$row3[NAME]."</td>";
		echo		"<td>".$row3[EMAIL]."</td>";
		echo		"<td>--</td>";
		//echo		"<td>--</td>";
		echo		"<td>customer</td>";
		echo		"</tr>";
	}
	
	echo '</table>';
	
	oci_commit($conn);
	oci_close($conn);
	} 
?>
	</div>
</div>