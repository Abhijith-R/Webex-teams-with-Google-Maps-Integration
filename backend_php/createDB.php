/*Copyright (c) 2019 Cisco and/or its affiliates.
This software is licensed to you under the terms of the Cisco Sample
Code License, Version 1.1 (the "License"). You may obtain a copy of the
License at
               https://developer.cisco.com/docs/licenses
               
All use of the material herein must be in accordance with the terms of
the License. All rights not expressly granted by the License are
reserved. Unless required by applicable law or agreed to separately in
writing, software distributed under the License is distributed on an "AS
IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
or implied.*/

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
