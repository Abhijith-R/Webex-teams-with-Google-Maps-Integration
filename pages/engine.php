<?php

//Database connection
include '../backend_php/connection.php';

$sqlFireStation = "SELECT * FROM incidents where assigned_vehicle='FE01' and status='open'";
$queryFireStation = mysqli_query($conn, $sqlFireStation);

//Get incident details for tracking
function getTrackIncident(){

//Database connection
include '../backend_php/connection.php';

$incidentID = "6";

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FEngine - FE01</title>

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

    <!-- Hiding map div when there is no incident -->
    <script type="text/javascript">
      function myFunction() {
          var totalRecords = $("#fsIncidentTable").DataTable().page.info().recordsDisplay; 
          if(totalRecords == 0){
              var mapDIV = document.getElementById("map_canvas");
              if (mapDIV.style.display === "none") {
                  mapDIV.style.display = "block";
              } else {
                  mapDIV.style.display = "none";
              }
          }
      }
    </script>




</head>

<body onload="initialize();myFunction();setRoutes(fsAddressArray[1],fsAddressArray[0])">
<form method="POST" id="fireStationForm">

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-brand" href="FireStation.php">Fire Engine - FE01</a>
            </div>
        </nav>
        <!--  Counters -->
        <div class="row">
            <div class="col-lg-4 col-md-8">
                <div class="panel" style="background-color: SlateBlue; height:150px;  " onClick="window.open('http://localhost:3333/pages/call.html','windowname',' width=400,height=200')">
                    <div class="panel-heading">
                        <div class="row" >
                            <div class="col-xs-3">
                                <i class="fa fa-phone fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-center">
                                <div class="huge"><p id="countFireIncidents" type="hidden" name="countFireIncidents"></p></div>
                                <div style="font-size: 40px;">Backup</div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-8">
                <div class="panel" style="background-color:gray;height:150px;" onClick="window.open('http://localhost:3333/pages/call.html','windowname',' width=400,height=200')">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-phone fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-center">
                                <div class="huge"><p id="countTotalOther" type="hidden" name="countTotalOther"></p></div>
                                <div style="font-size: 40px;">Police</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-8">
                <div class="panel" style="background-color:Tomato;height:150px;" onClick="window.open('http://localhost:3333/pages/call.html','windowname',' width=400,height=200')">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-phone fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-center">
                                <div class="huge"><p id="totalInc" type="hidden" name="totalInc"></p></div>
                                <div style="font-size: 40px;">Medics</div>
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
        toPersonEmail: 'someone@somedomain.com'
      });
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
