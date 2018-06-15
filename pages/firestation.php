<?php

//Database connection
include '../backend_php/connection.php';

// Total Counter
$incidentCountsql = "SELECT count(id) as total from incidents where fs_address='30th Cross Road, Padmanabha Nagar, Banashankari, Bengaluru'";
$incidentCount=mysqli_query($conn,$incidentCountsql);
$incidata=mysqli_fetch_assoc($incidentCount);

// Fire Counter
$fireCountsql = "SELECT count(id) as firetotal from incidents where fs_address='30th Cross Road, Padmanabha Nagar, Banashankari, Bengaluru' and type='fire'";
$fireCount=mysqli_query($conn,$fireCountsql);
$firedata=mysqli_fetch_assoc($fireCount);

// Other incident Counter
$otherCountsql = "SELECT count(id) as othertotal from incidents where fs_address='30th Cross Road, Padmanabha Nagar, Banashankari, Bengaluru' and type!='fire'";
$otherCount=mysqli_query($conn,$otherCountsql);
$otherdata=mysqli_fetch_assoc($otherCount);



$sql = "SELECT * from incidents where fs_address='30th Cross Road, Padmanabha Nagar, Banashankari, Bengaluru' and assigned_vehicle IS NULL";

    
$query = mysqli_query($conn, $sql);

if (!$query) {
  die ('SQL Error: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_array($query))
    {
      $id[]= $row['id'];
    }
$idarray = json_encode($id);

$sqlFireStation = "SELECT * FROM incidents where fs_address='30th Cross Road, Padmanabha Nagar, Banashankari, Bengaluru'";
$queryFireStation = mysqli_query($conn, $sqlFireStation);

// Assign fire engine to a incident
function assignFireEngine(){

//Database connection
include '../backend_php/connection.php';

$idFireIncident = $_POST['inciId'];
$fireEngine = $_POST['engine'];
echo $idFireIncident;
echo $fireEngine;

$sql = "update incidents set assigned_vehicle = '$fireEngine' where id = '$idFireIncident'";
$query = mysqli_query($conn, $sql);
}

//Get incident details for tracking
function getTrackIncident(){

//Database connection
include '../backend_php/connection.php';

$incidentID = $_POST['fsincidentId'];

$sql = "SELECT * FROM incidents where id='$incidentID'";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query))
    {
      $src= $row['address'];
      $dest= $row['fs_address'];
      $fs_id = $row['id'];
    }
$arr=array($src,$dest,$fs_id);
$trackArray = json_encode($arr);

return $trackArray;
}

//Close Incident
function closeIncident(){
    
//Database connection
include '../backend_php/connection.php';

$closeincidentID = $_POST['closeincidentIdd'];

$closesql = "update incidents set status = 'closed' where id = '$closeincidentID'";
$query = mysqli_query($conn, $closesql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fire Station</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Fonts Awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/chat-window.css">
    <!-- Fonts Awesome css -->
    <link href="../dist/css/fire-station.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.s4d.io/widget-space/production/main.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Vehicle Tracking javascript -->
    <script src="https://code.s4d.io/widget-space/production/bundle.js"></script>

    <!-- Data tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
    <!-- Custom css -->
    <link href="../dist/css/fire-station.css" rel="stylesheet">

    <!-- Map - Tracking -->
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


    <!-- Incident Tracking -->
    <script type="text/javascript">
        var incidentArray = '<?php echo getTrackIncident(); ?>';
        var fsAddressArray = JSON.parse(incidentArray);
    </script>

</head>

<body onload="initialize()">
<form method="POST" id="fireStationForm">

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="FireStation.php">Fire Station</a>
            </div>

            <div class="navbar-default sidebar" role="navigation" >
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="FireStation.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a><br><br>
                        </li>

                        <!-- Assign fire engine -->
                        <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#fireEnginetDropdown">
                                    <i class="fa fa-plus" style="font-size:15px"></i> Assign Fire Engine
                                    <span class="caret"></span>
                        </button>
                        <li>

                             <div class="collapse text-center keep-open" display="inline-block" id="fireEnginetDropdown">

                                <ul class="col-xs-12 list-unstyled">
                                <br>
                                    <li>
                                        <div class="form-group">
                                            <label for="inciID">Incident ID</label>
                                            <select name="inciId" class="form-control" id="isSelect" >
                                                <option value="" selected disabled>Please select</option>
                                          
                                            </select>
                                        </div>

                                    </li>
                                    <br>

                                    <li>
                                        <div class="form-group">
                                            <label for="engine">Fire Engine</label>
                                            <select class="form-control" name="engine" id="engine">
                                                <option value="" selected disabled>Please select</option>
                                                <option>FE01</option>
                                                <option>FE02</option>
                                                <option>FE03</option>
                                                <option>FE04</option>
                                                <option>FE05</option>
                                            </select>
                                        </div>

                                    </li>
                                    <br/>
                                    <li>
                                        <input type="submit" id="submit" class="btn btn-warning btn-block" onsubmit='<?php echo assignFireEngine(); ?>' value="Assign">
                                    </li>
                                    <br>
                                </ul>
                             </div>

                            <br>
                        </li>
                    </ul>
                    <br>
                    <!-- Close Incident -->
                     <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#closeIncidentModal">Close Incident</button>
                    <br>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                    
                </div>
            </div>

           <!--  Counters -->
            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-fire-extinguisher fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><p id="countFireIncidents" type="hidden" name="countFireIncidents"></p></div>
                                    <div>Fire Incidents</div>
                                    <p style="font-size: 50px;"><?php echo $firedata['firetotal'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bolt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><p id="countTotalOther" type="hidden" name="countTotalOther"></p></div>
                                    <div>Other Incidents</div>
                                    <p style="font-size: 50px;"><?php echo $otherdata['othertotal'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-warning fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><p id="totalInc" type="hidden" name="totalInc"></p></div>
                                    <div>Total Incidents</div>
                                    <p style="font-size: 50px;"><?php echo $incidata['total'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incidents table -->
            <div class="row">
                <div class="col-lg-12">
                   <table class="table table-striped table-bordered" style="width:100%" id="fsIncidentTable">
                        <caption class="title">Refresh Table  <a href="FireStation.php">
                        <span style="font-size:1.5em;" class="glyphicon glyphicon-refresh"></span>
                      </a></caption>
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
                            <th>Vehicle Assigned</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no   = 1;
                        $total  = 0;
                        while ($rowFireStation = mysqli_fetch_array($queryFireStation))
                        {
                          echo '<tr>
                              <td>'.$rowFireStation['id'].'</td>
                              <td>'.$rowFireStation['incident_name'].'</td>
                              <td>'.$rowFireStation['type'].'</td>
                              <td>'.$rowFireStation['address'].'</td>
                              <td>'.$rowFireStation['locality'].'</td>
                              <td>'.$rowFireStation['severity'].'</td>
                              <td>'.$rowFireStation['description'].'</td>
                              <td>'.$rowFireStation['caller_name'].'</td>
                              <td>'.$rowFireStation['caller_phone'].'</td>
                              <td>'.$rowFireStation['fs_address'].'</td>
                              <td>'.$rowFireStation['incident_date'].'</td>
                              <td>'.$rowFireStation['assigned_vehicle'].'</td>
                              <td>'.$rowFireStation['status'].'</td>
                            </tr>';
                        }?>
                        </tbody>
                        <tfoot>
                          <tr>
                          <br>
                          </tr>
                        </tfoot>
                      </table>
                      <!-- Map - Tracking -->
                      <div id="error-msg"></div>
                      <div id="map_canvas" class="col-lg-6" style="width:100%;height:500px;">
                      </div>               
                </div>
            </div>
        </div>
</div>
</form>

<!-- Form to track incident -->
<form method="POST" id="fireStationForm2">
        <div class="col-lg-3" style="margin-top: -1100px; width: 250px">
            <input id="fsincidentIdd" type="text" name="fsincidentId" placeholder="Track Incident" style="width:200px;" />    
        </div>

        <!-- Fetch Incident -->
        <div class='col-lg-2' style="margin-top: -1050px; width: 250px">
            <div class="btn-group buttons">
              <button class="btn btn-primary btn-block" type="submit" name="fsTrack" id="fsTrack" onsubmit='<?php echo getTrackIncident(); ?>' style="width:200px;">
                <i class="fa Example of chevron-circle-left fa-chevron-circle-left" style="font-size:20px"></i> Fetch Incident
              </button> 
            </div>
        </div> 

        <!-- Track Incident -->
        <div class='col-lg-2' style="margin-top: -1000px; width: 250px">
          <div class="btn-group buttons">
            <button class="btn btn-primary" type="button" name="trackfsIncident" id="trackfsIncident" onclick="setRoutes(fsAddressArray[1],fsAddressArray[0]);" style="width:200px;"/>
                        <i class="fa fa-location-arrow" style="font-size:20px"></i> Track
            </button>
        </div>

</form>

<!-- Modal to close an incident -->
<form method="POST" action="FireStation.php">
    <div class="modal fade" id="closeIncidentModal" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Close Incicent</h4>
          </div>
          <div class="modal-body">
              <input id="closeincidentIdd" type="text" name="closeincidentIdd" placeholder="Incident ID" style="width:200px;"> 
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" onsubmit='<?php echo closeIncident(); ?>'>Close</button>
          </div>
        </div>
      </div>
    </div>
</form>

<!-- Cisco Webex Teams Chat window -->
<form id="sparkform">
        <div class="row pt-3 pull-right" >
            <div class="chat-main " style="margin-right: -15%;" >
                <div class="col-md-12 chat-header">
                    <div class="row header-one text-white p-1">
                        <div class="col-lg-6 name pl-2">
                            <h6 class="ml-1 mb-0" style="color: white">Cisco Webex Teams</h6>
                        </div>
                        <div class="col-md-6 options text-right pr-0">
                            <i class="fa fa-window-minimize hide-chat-box hover text-center pt-1"></i>
                            <p class="arrow-up mb-0">
                                <i class="fa fa-arrow-up text-center pt-1"></i>
                            </p>
                            <i class="fa fa-times hover text-center pt-1"></i>
                        </div>
                    </div>
                   
                </div>
                <div class="chat-content ">
                    <div id="my-ciscospark-widget" style="width: 300px; height: 500px;"/>
                </div>
            </div>
        </div>
    </div>

</form>

    <!-- Initialize Cisco Webex Teams plugin -->
    <script type="text/javascript">
    $(document ).ready(function() {
    $('#my-ciscospark-widget').hide();
});
    </script>
    <script type="text/javascript">
      $('.hide-chat-box').click(function(){
        $('#my-ciscospark-widget').slideToggle();
 });
    </script>

    <script>
      var widgetEl = document.getElementById('my-ciscospark-widget');
      // Init a new widget
      ciscospark.widget(widgetEl).spaceWidget({
        accessToken: result[4],
        spaceId: 'Your Space ID'
      });
    </script>


    <!-- Populate incidentID -->
    <script type="text/javascript">
      var addressArray = '<?php echo $idarray; ?>';
      var addressArrayElement = JSON.parse(addressArray)
      var select = document.getElementById("isSelect");
      for (var i = 0; i<addressArrayElement.length; i++){
          var opt = addressArrayElement[i];
          var option = document.createElement("option");
          option.text = opt;
          option.value = opt;
          select.appendChild(option);
      }
    </script>

    <!-- Initialize Datatable -->
    <script>
          $(document).ready(function(){
              $("#fsIncidentTable").DataTable({

             });
            });
    </script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

   <!--  Data Table   -->  
    <script src='https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js'></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" charset="utf-8"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Locate fire station JavaScript -->
    <!-- <script src="../dist/js/fire-station-map.js"></script> -->

    <script src='../dist/js/insert.js'></script>


</body>

</html>
