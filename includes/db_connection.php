<?php
	define("DB_SERVER", "127.0.0.1");
	define("DB_USER", "root");
	define("DB_PASS", "Dgjnb22Dgjnb22!");
	define("DB_NAME", "studi_production");

	//1. Create a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

	// Test if caonnection succeeded
	if(mysqli_connect_errno()){
			die("Database connection failed: " .
			mysqli_connect_error() .
				" (" . mysqli_connect_errno() . ")"
			);
		}
?>