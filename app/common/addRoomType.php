<?php
	
	date_default_timezone_set("Asia/Singapore");
	echo "connecting";
	putenv('ORACLE_HOME=/oraclient');
	// connect
	$conn = oci_connect('a0091794', 'crse1410', 'sid3');
	$today = date("m/d/Y");
	$today = date ("m/d/Y", strtotime("+60 day", strtotime($today)));
	$date = date("m/d/Y");
	
	echo $today;
	$sth = oci_parse($conn, "select max(room_date)as newdate from roomtype");
	$suc = oci_execute($sth, OCI_DEFAULT);
	if($row = oci_fetch_array($sth)){
		$date = date_format(date_create($row[NEWDATE]),'m/d/Y');
		$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
	}
	echo "current max $date";
	echo "add until $today";

	$sth = oci_parse($conn, "alter session set NLS_DATE_FORMAT='MM/DD/YYYY'");
	oci_execute($sth, OCI_DEFAULT);

	while (strtotime($date) <= strtotime($today)) {

		$fh = fopen('insertRoomType.sql','r');
		$select_ry = '';
		while ($line = fgets($fh)) {
			echo $line;
			$select_ry = str_replace("###", $date, $line);
			$sth2 = oci_parse($conn, $select_ry);
			$suc2 = oci_execute($sth2, OCI_DEFAULT);
			if(!$suc2){
				oci_close($conn);
				break;
			}
			echo $select_ry;
			echo "======";
			echo $suc2;
			echo '<hr>';
		}
		fclose($fh);
		$date = date ("m/d/Y", strtotime("+1 day", strtotime($date)));
	}


	// commit
	oci_commit($conn);
	
	// disconnect
	oci_close($conn);
?>