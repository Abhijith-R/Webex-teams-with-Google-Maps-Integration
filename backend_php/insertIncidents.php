<?php
$link = new mysqli("127.0.0.1", "root", "newpassword","mydb");
$incidentName = $_POST['incident'];
$type = $_POST['type'];
$address = $_POST['address'];
$locality = $_POST['location'];
$severity = $_POST['severe'];
$description = $_POST['desc'];
$callerName = $_POST['callerName'];
$phNumber = $_POST['callerph'];
$fsAddress = $_POST['fireStationAddress'];

// sql to create table
$sql = "INSERT INTO `Incidents`(`incident_name`, `type`, `address`, `locality`, `severity`, `description`, `caller_name`, `caller_phone`,`fs_address`,`incident_date`) VALUES ('$incidentName','$type','$address','$locality','$severity','$description','$callerName','$phNumber','$fsAddress',NOW())";

if ($link->query($sql) === TRUE) {
    echo "Table Incidents created successfully";
} else {
    echo "Error creating table: " . $link->error;
}

mysqli_close($link);
