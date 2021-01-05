<!DOCTYPE html>
<html>
<head>
	<title>Config</title>
	<meta charset="utf-8">
</head>
<body>

<?php
session_start();
$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "mynger"; /* Database name */

$con = mysqli_connect($host, $user, $password, $dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
</body>
</html>