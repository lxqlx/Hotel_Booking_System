<?php
	session_start();
	if($_SESSION["role"]!="admin")
	echo "<script>location.href='../login.php'</script>";
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
	<div class="panel-heading">Add Customer</div>

  <!-- Table -->
  <div class="panel-body">
	<div class="container" style="max-width:300px;padding:10px;">
	<?php
	
	if(isset($_POST["email"])){
	ob_start();
	putenv('ORACLE_HOME=/oraclient');
	$conn=oci_connect('a0091794','crse1410','sid3');
	
	$name=$_POST["name"];
	$email=$_POST["email"];
	$password=sha1($_POST["password"]);

	$check = oci_parse($conn, "select email from Customer where email='$email'");
	$customer= oci_parse($conn, "insert into Customer(name,email,password) values('$name','$email','$password')");
	
	oci_execute($check, OCI_DEFAULT);
	//$result=oci_execute($customer, OCI_DEFAULT);
	
	if(oci_fetch($check)>=1)
		echo '<p style="color:red;">Sorry, this email address has been registed</p>';
	else{
		oci_execute($customer, OCI_DEFAULT);
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
					<label>Customer Name</label>
                      <input type="text" class="form-control" name="name" required/>
                    </div>
					<div class="form-group">
					<label>Customer Email</label>
                      <input type="email"  class="form-control" name="email" required/>
                    </div>
					<div class="form-group">
					<label>Password</label>
                      <input type="password" class="form-control" name="password" required/>
                    </div>
				
					<div class="form-group">
                    <button type="submit" class="btn btn-primary " >Add Customer</button>
					</div>
			</form>
			</div>

	</div>
</div>