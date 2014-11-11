<?php	

	putenv('ORACLE_HOME=/oraclient');
	$conn = oci_connect('a0091794','crse1410', 'sid3');
	if($conn)
		echo "successful connection!<br>";
	/*
	$create = "create table admin(email varchar(256) primary key, name varchar(256), password varchar(256) check(length(password)>5))";
	oci_execute(oci_parse($conn, $create));
	oci_commit($conn);
	*/
	$insert = "insert into Manager(email, name, password)values('bohua@live.com','bohua','password')";
	oci_execute(oci_parse($conn, $insert));
	oci_commit($conn);
	/*
	$sql = "select email from admin where email='bohua@live.com'";
	$result =oci_parse($conn, $sql);
	oci_execute($result,OCI_DEFAULT);

	if ($row = oci_fetch_array($result)){
		echo "successful selected!<br>";
		echo $row[EMAIL];
		}
	oci_commit($conn);*/
	oci_close($conn);
?>