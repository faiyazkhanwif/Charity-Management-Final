<?php
$databaseHost = 'localhost';
$databaseName = 'charitymanagement';
$databaseUser = 'ykchiam';
$databasePass = 'chiam123';

$conn = mysqli_connect($databaseHost, $databaseUser, $databasePass, $databaseName);
if (!$conn) {
	echo "Connection error: ".mysqli_connect_error();
}
?>

