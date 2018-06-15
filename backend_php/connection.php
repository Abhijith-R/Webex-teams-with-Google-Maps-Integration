<?php

$db_host = '127.0.0.1'; // Server Name
$db_user = 'root'; // Username
$db_pass = 'newpassword'; // Password
$db_name = 'mydb'; // Database Name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
  die ('Failed to connect to MySQL: ' . mysqli_connect_error());  
}

?>