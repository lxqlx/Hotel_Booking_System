<?php
	session_start();
	print'
		<form action="control/logout.php" class="navbar-form navbar-right" role="form" method="post">
			<a href="view/profile.php">';
		echo $_SESSION["name"];
	print		
			'</a>&nbsp;&nbsp;
			<button name="logout" type="submit" class="btn btn-primary btn-sm">Logout</button>
		</form>
	';
?>
