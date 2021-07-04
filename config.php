<?php
$databaseHost = 'localhost';
$databaseName = 'charitymanagement';
$databaseUser = 'root';
$databasePass = '';

$conn = mysqli_connect($databaseHost, $databaseUser, $databasePass, $databaseName);
if (!$conn) {
	echo "Connection error: ".mysqli_connect_error();
}
?>

