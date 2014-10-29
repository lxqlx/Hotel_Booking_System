<?php
	echo 'First Name       : '.$fName = $_POST['fName'].'<br/>';
	echo 'Last Name        : '.$lName = $_POST['lName'].'<br/>';
	echo 'Email Address    : '.$email = $_POST['email'].'<br/>';
	echo 'Re-Email Address : '.$reemail = $_POST['reemail'].'<br/>';
	echo 'Password         : '.$password = sha1($_POST['password']).'<br/>';
	echo 'Birth Day        : '.$month = $_POST['month'].'-'. $day = $_POST['day'].'-'. $year = $_POST['year'].'<br/>';
	echo 'Gender		   : '.$optionsRederadios = $_POST['optionsRadios'];
	
?>