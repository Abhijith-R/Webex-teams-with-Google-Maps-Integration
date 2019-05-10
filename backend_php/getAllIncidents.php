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

include 'connection.php';

$sql = 'SELECT * FROM incidents';
    
$query = mysqli_query($conn, $sql);

if (!$query) {
  die ('SQL Error: ' . mysqli_error($conn));
}

function getIncidentDetails(){
$db_host = '127.0.0.1'; // Server Name
$db_user = 'root'; // Username
$db_pass = 'newpassword'; // Password
$db_name = 'mydb'; // Database Name

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$incidentID = $_POST['incidentId'];
$sql = "SELECT * FROM incidents where id='$incidentID'";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query))
    {
      $src= $row['address'];
      $dest= $row['fs_address'];
    }
$arr=array($src,$dest);
$incidentArray = json_encode($arr);

return $incidentArray;
}

// if(array_key_exists('test',$_POST)){
//    getIncidentDetails();
// }

?>
<html>
<head>
  <title>Displaying MySQL Data in HTML Table</title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fire Command Center</title>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <script src='https://code.jquery.com/jquery-1.12.3.js'></script>
    <script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="../dist/js/vehicle-movement.js"></script>

     <!-- Get Google Maps API token from a file -->
    <script type="text/javascript">
        var result;
        var rawFile = new XMLHttpRequest();
            rawFile.open("POST", "../dist/others/tokens.txt", false);
            rawFile.onreadystatechange = function ()
            {
                if(rawFile.readyState === 4)
                {
                    if(rawFile.status === 200 || rawFile.status == 0)
                    {
                        var tokens = rawFile.responseText;
                        result = tokens.split("\n");
                    }
                }
            }
            rawFile.send(null)

    </script>


    <!-- Generate Google Maps API script tag -->
    <script>
        var mapsToken=result[1];

        var url = "http://maps.google.com/maps/api/js?key="+mapsToken+"&sensor=false";

        document.write("<script type='text/javascript' src='"+ url + "'><\/scr" + "ipt>");
    </script>
    
    <script type ="text/javascript" src="../dist/js/v3_epoly.js"></script>

    <script type="text/javascript">
      var MyJSStringVar = '<?php echo getIncidentDetails(); ?>';
      var addressArray = JSON.parse(MyJSStringVar);
    </script>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts Awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">

    <!-- Custom css -->
    <link href="../dist/css/fire-station.css" rel="stylesheet">

</head>
<body onload="initialize()">
<form action="" method="POST" id="allIncidents">
<div>
  <table class="table table-striped table-bordered" style="width:100%" id="incidentTable">
    <caption class="title">List of Incidents</caption>
    <thead>
      <tr>
        <th>NO</th>
        <th>Incident Name</th>
        <th>Type</th>
        <th>Address</th>
        <th>Locality</th>
        <th>Severity</th>
        <th>Description</th>
        <th>Caller Name</th>
        <th>Caller Phone Number</th>
        <th>Fire Station Address</th>
        <th>Incident Date</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $no   = 1;
    $total  = 0;
    while ($row = mysqli_fetch_array($query))
    {
      echo '<tr>
          <td>'.$row['id'].'</td>
          <td>'.$row['incident_name'].'</td>
          <td>'.$row['type'].'</td>
          <td>'.$row['address'].'</td>
          <td>'.$row['locality'].'</td>
          <td>'.$row['severity'].'</td>
          <td>'.$row['description'].'</td>
          <td>'.$row['caller_name'].'</td>
          <td>'.$row['caller_phone'].'</td>
          <td>'.$row['fs_address'].'</td>
          <td>'.$row['incident_date'].'</td>
        </tr>';
    }?>
    </tbody>
    <tfoot>
      <tr>
      <br>
      </tr>
    </tfoot>
  </table>

</div>

<div class="col-lg-3">
      <input id="incidentId" type="text" class="form-control" name="incidentId" placeholder="Incident ID">                    
</div>

  <div class='col-lg-2'>
    <div class="btn-group buttons"><button class="btn btn-warning" type="submit" name="test" id="test" style="width:200px;"/>
                    <i class="fa Example of chevron-circle-left fa-chevron-circle-left" style="font-size:20px"></i> Fetch Incident
                    </button> 
                    </div>
  </div>

  <div class='col-lg-2'>
    <div class="btn-group buttons"><button class="btn btn-primary" type="button" name="track" id="track" onclick="setRoutes(addressArray[1],addressArray[0]);" style="width:200px;"/>
                        <i class="fa fa-location-arrow" style="font-size:20px"></i> Track
                    </button>
    </div>
  </div>
  <div class='col-lg-2'>
    <div class="btn-group buttons"><button class="btn btn-success" type="button" onclick="window.location.href='../pages/index.php';">
                                    <i class="fa fa-angle-double-left" style="font-size:20px"></i> Go Back
                                  </button>
    </div>
  </div>

  <div id="error-msg"></div>

<div id="map_canvas" style="width:100%;height:500px;"></div>

  <script>
          $(document).ready(function(){
      $("#incidentTable").DataTable({

     });
    });
  </script>
</form>
</body>
</html>
