<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Add Hotel Manager</div>

  <!-- Table -->
  <div class="panel-body">
	<div class="container" style="max-width:300px;padding:10px;">
	<?php
	
	if(isset($_POST["email"])&isset($_POST["hotel_name"])&isset($_POST["hotel_address"])){
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	
	$name=$_POST["name"];
	$email=$_POST["email"];
	$password=sha1($_POST["password"]);
	$hotel_name=$_POST["hotel_name"];
	$hotel_address=$_POST["hotel_address"];

	$check1 = oci_parse($conn, "select name from Manager where email='$email'");
	$check2 = oci_parse($conn, "select name from Hotel where name='$hotel_name' and address='$hotel_address'");
	$add=oci_parse($conn, "insert into Manager(name,email,password,hotel_name,hotel_address) values('$name','$email','$password','$hotel_name','$hotel_address')");
	
	oci_execute($check1, OCI_DEFAULT);
	oci_execute($check2, OCI_DEFAULT);
	//$result=oci_execute($customer, OCI_DEFAULT);
	
	if(oci_fetch($check1)>=1)
		echo '<p style="color:red;">Sorry, this email address has been registered</p>';
	else if(oci_fetch($check2)==0)
		echo '<p style="color:red;">Sorry, no such hotel exists!</p>';
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
					<label>Manager Name</label>
                      <input type="text" class="form-control" name="name" required/>
                    </div>
					<div class="form-group">
					<label>Manager Email</label>
                      <input type="email"  class="form-control" name="email" required/>
                    </div>
					<div class="form-group">
					<label>Password</label>
                      <input type="password" class="form-control" name="password" required/>
                    </div>
					<div class="form-group" style="color:red;">Manager must be assigned to an existing hotel.</div>
					<div class="form-group">
					<label>Hotel Name: (required)</label>
                      <input type="text" class="form-control" name="hotel_name" required/>
                    </div>
					
					<div class="form-group">
					<label>Hotel Address: (required)</label>
                      <input type="text" class="form-control" name="hotel_address" required/>
                    </div>
					
					<div class="form-group">
                    <button type="submit" class="btn btn-primary " >Add Hotel Manager</button>
					</div>
			</form>
			</div>

	</div>
</div>