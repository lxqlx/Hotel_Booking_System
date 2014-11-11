<?php	
	$email = $_POST["email"];
	$pass = sha1($_POST["password"]);
	
	putenv('ORACLE_HOME=/oraclient');
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	
	$sql="select * from Manager where email='$email' and password='$pass'";
	$result = oci_parse($conn, $sql);
	oci_execute($result, OCI_DEFAULT);
	if( $row=oci_fetch_array($result)){
		session_start();
		$_SESSION["name"] = $row[NAME];
		$_SESSION["email"] = $email;
		$_SESSION["role"] = "manager";
		$_SESSION["hotel_name"] = $row[HOTEL_NAME];
		$_SESSION["hotel_address"] = $row[HOTEL_ADDRESS];
		echo "<script>location.href='../manager.php'</script>";
		}
	else{
		echo "your account info is wrong! Please login again.";
	}
	oci_commit($conn);
	oci_close($conn);
?>