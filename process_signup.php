<?php
ob_start();
function insertCustomer()
{

	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');


	$Name = $_POST['UserName'];
	$email = $_POST['UserEmail'];
	$password = sha1($_POST['UserPassword']);
	//echo 'Name        : '.$Name.'<br/>';
	//echo 'Email Address    : '.$email.'<br/>';
	//echo 'Password         : '.$password.'<br/>';
	$insert_str = "insert into Customer values ('".$email."', '".$Name."', '".$password."')";
	//echo $insert_str;

	// insert
	$sth = oci_parse($conn, $insert_str);
	$suc = @oci_execute($sth, OCI_DEFAULT);
	//if ($suc)
	//	//echo "<p>Successfully added an Customer.</p>";
	//	header('Location: index.php');
	//else{
	//	//echo "<p>Error adding an Customer.</p>";
	//	header('Location: sign_up.php');
	//}

	// select
	//$sth = oci_parse($conn, "select email, name, password from Customer");
	//oci_execute($sth, OCI_DEFAULT);
	//while ($row = oci_fetch_array($sth)) {
	//echo "<p>Email = ", $row[EMAIL], ", Name = ", $row[NAME],", Password_hash = ", $row[PASSWORD], "</p>\n";
	//}
	
	// delete
	//$sth = oci_parse($conn, "delete from Customer");
	//if (oci_execute($sth, OCI_DEFAULT))
	//echo "<p>Successfully deleted all Customers.</p>";
	//else echo "<p>Error deleting Customers.</p>";
	
	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
	return $suc;
}

?>
