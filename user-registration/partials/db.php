<?php
// Database connection
function connection()
{
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "user-registrations";
	$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}
