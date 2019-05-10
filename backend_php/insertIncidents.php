/*
Copyright (c) 2019 Cisco and/or its affiliates.
This software is licensed to you under the terms of the Cisco Sample
Code License, Version 1.1 (the "License"). You may obtain a copy of the
License at
               https://developer.cisco.com/docs/licenses
               
All use of the material herein must be in accordance with the terms of
the License. All rights not expressly granted by the License are
reserved. Unless required by applicable law or agreed to separately in
writing, software distributed under the License is distributed on an "AS
IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
or implied.
*/

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
