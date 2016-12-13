<?php
	$con=mysqli_connect("localhost","root","","ecommerce");
	session_start();

	if (mysqli_connect_errno()) {
		echo "The connection was not established ".mysqli_connect_errno();
	}

?>