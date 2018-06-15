<?php
$link = new mysqli("127.0.0.1", "root", "newpassword","mytestdb");

// sql to create table
$sql = "CREATE TABLE Incidents (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
incident_name VARCHAR(30) NOT NULL,
type VARCHAR(30),
address VARCHAR(50) NOT NULL,
locality VARCHAR(50),
severity VARCHAR(10) NOT NULL,
description VARCHAR(100),
caller_name VARCHAR(20),
caller_phone VARCHAR(20),
fs_address VARCHAR(100),
incident_date TIMESTAMP,
assigned_vehicle VARCHAR(20),
status VARCHAR(20)
)";

if ($link->query($sql) === TRUE) {
    echo "Table Incidents created successfully";
} else {
    echo "Error creating table: " . $link->error;
}

mysqli_close($link);