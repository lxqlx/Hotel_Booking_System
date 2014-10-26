<?php
putenv('ORACLE_HOME=/oraclient');
// connect
$conn = oci_connect('a0091794', 'crse1410', 'sid3');

// insert
$sth = oci_parse($conn, "insert into employee values ('10', 'John')");
if (oci_execute($sth, OCI_DEFAULT))
	echo "<p>Successfully added an employee.</p>";
else 	echo "<p>Error adding an employee.</p>";

// select
$sth = oci_parse($conn, "select id, name from employee");
oci_execute($sth, OCI_DEFAULT);
while ($row = oci_fetch_array($sth)) {
echo "<p>Id = ", $row[ID], ", Name = ", $row[NAME], "</p>\n";
}

// delete
$sth = oci_parse($conn, "delete from employee");
if (oci_execute($sth, OCI_DEFAULT))
echo "<p>Successfully deleted all employees.</p>";
else echo "<p>Error deleting employees.</p>";

// commit
oci_commit($conn);

// disconnect
oci_close($conn);
?>

