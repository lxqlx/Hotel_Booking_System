<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Add Hotel</div>

  <!-- Table -->
  <div class="panel-body">
	<div class="container" style="max-width:300px;padding:10px;">
	<?php
	
	if(isset($_POST["name"])&isset($_POST["address"])){
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	
	$name=$_POST["name"];
	$address=$_POST["address"];
	$rating=$_POST["rating"];
	$facility=$_POST["facility"];
	$phone_no=$_POST["phone_no"];

	$check = oci_parse($conn, "select name from Hotel where name='$name' and address='$address'");
	$add= oci_parse($conn, "insert into Hotel(name,address,rating,facility,phone_no) values('$name','$address','$rating','$facility','$phone_no')");
	
	oci_execute($check, OCI_DEFAULT);
	//$result=oci_execute($customer, OCI_DEFAULT);
	
	if(oci_fetch($check)>=1)
		echo '<p style="color:red;">Sorry, this hotel has been registed</p>';
	else{
		oci_execute($add, OCI_DEFAULT);
		echo '<p style="color:green;">Successfull!</p>';	
			}
	oci_commit($conn);
	oci_close($conn);
	} 
	?>
	</div>
			<div class="container" style="max-width:300px;padding-top:10px;">
			<form action="" method="post" >
					<div class="form-group">
					<label>Hotel Name: (required)</label>
                      <input type="text" class="form-control" name="name" required/>
                    </div>
					<div class="form-group">
					<label>Hotel Address: (required)</label>
                      <input type="text"  class="form-control" name="address" required/>
                    </div>
					<div class="form-group">
					<label>Contact Number:</label>
                      <input type="text" class="form-control" name="phone_no"/>
                    </div>
					<div class="form-group">
						<label>Hotel Rating:(Integer 3~5)</label>
                      <input type="number" class="form-control" name="rating" />
                    </div>
						<div class="form-group">
						<label>Hotel Facility:</label>
                      <input type="text" class="form-control" name="facility" />
                    </div>
					<div class="form-group">
                    <button type="submit" class="btn btn-primary " >Add Hotel</button>
					</div>
			</form>
			</div>

	</div>
</div>