<?php

include '../backend_php/connection.php';

// Total Counter
$incidentCountsql = "SELECT count(id) as total from incidents";
$incidentCount=mysqli_query($conn,$incidentCountsql);
$incidataIndex=mysqli_fetch_assoc($incidentCount);

// Fire Counter
$fireCountsql = "SELECT count(id) as firetotal from incidents where type='fire'";
$fireCount=mysqli_query($conn,$fireCountsql);
$firedataIndex=mysqli_fetch_assoc($fireCount);

// Other incident Counter
$otherCountsql = "SELECT count(id) as othertotal from incidents where type!='fire'";
$otherCount=mysqli_query($conn,$otherCountsql);
$otherdataIndex=mysqli_fetch_assoc($otherCount);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fire Command Center</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Fonts Awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="../dist/css/fire-station.css" rel="stylesheet">

    <!-- Chat Window -->
    <link rel="stylesheet" href="../dist/css/chat-window.css">
    <link rel="stylesheet" href="https://code.s4d.io/widget-space/production/main.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.s4d.io/widget-space/production/bundle.js"></script>


</head>

<body>
<form action="../backend_php/insertIncidents.php" method='POST' id="myform">

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Command Center</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <!-- .sidebar-collapse -->
            <div class="navbar-default sidebar" role="navigation" >
                 <!-- Buttons to make call -->
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a><br><br>
                        </li>

                        <!-- Button to create incident -->
                        <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#incidentDropdown">
                                    <i class="fa fa-plus" style="font-size:15px"></i> Create Incident
                                    <span class="caret"></span>
                        </button>

                        <!-- Incident Details Dropdown-->
                        <li>

                             <div class="collapse text-center keep-open" display="inline-block" id="incidentDropdown">

                                <ul class="col-xs-12 list-unstyled">
                                <br>
                                    <li>   
                                        <label for="incident"> Incident Name:</label>
                                        <input type="text" class="form-control" name="incident" id="incident">
                                    </li>

                                    <br>
                                    <li>
                                        <label for="type">Type:</label>
                                        <input type="text" class="form-control" name="type" id="type">
                                    </li>

                                    <br>
                                    <li>
                                        <label for="address">Address:</label>
                                        <input type="text" class="form-control" placeholder="&#xF002;" name="address" id="address">
                                    </li>

                                    <br>
                                    <li>
                                        <label for="location"> Locality</label>
                                        <input type="text" class="form-control" name="location" id="location">
                                    </li>
                                    <br>
                                    <li>
                                        <div class="form-group">
                                            <label for="severe">Severity</label>
                                            <select class="form-control" name="severe" id="severe">
                                                <option value="" selected disabled>Please select</option>
                                                <option>High</option>
                                                <option>Normal</option>
                                                <option>Low</option>
                                            </select>
                                        </div>

                                    </li>
                                    <li>
                                        <label for="desc"> Description</label>
                                        <input type="text" class="form-control" name="desc" id="desc">
                                    </li>
                                    <li>
                                        <label for="callerName"> Caller Name</label>
                                        <input type="text" class="form-control" name="callerName" id="callerName">
                                    </li>
                                    <br>
                                    <li>
                                        <label for="callerph">Phone Number</label>
                                        <input type="text" class="form-control" name="callerph" id="callerph">
                                    </li>
                                    <br>
                                    <li>
                                        <label for="fireStationAddress"> Fire Station Address</label>
                                        <input type="text" class="form-control" name="fireStationAddress" id="fireStationAddress">
                                    </li>

                                    <br>
                                    <li>
                                        <input type="button" class="btn btn-primary btn-block" onclick='codeAddress()' value="Locate Address">
                                        <br>
                                        <input type="submit" id="submit" class="btn btn-warning btn-block" value="Submit Incident">
                                    </li>
                                    <br>
                                </ul>
                             </div>
                            <br>
                        </li>
                    </ul>

                    <button class="btn btn-primary btn-block" type="button" onclick="window.location.href='../backend_php/getAllIncidents.php';">
                                    <i class="fa fa-bars" style="font-size:20px"></i> List Incidents
                    </button>
                </div>
                <!-- /Buttons to make call -->
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <!-- Counters -->
            <div class="row">
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-fire-extinguisher fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><p id="countCalls" type="hidden" name="countCalls"></p></div>
                                    <div>Total Calls</div>
                                    <p style="font-size: 50px;"><?php echo $incidataIndex['total'];?></p>
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
                                    <div class="huge"><p id="countIncidents" type="hidden" name="countIncidents"></p></div>
                                    <div>Fire Incidents</div>
                                    <p style="font-size: 50px;"><?php echo $firedataIndex['firetotal'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bolt fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><p id="countOther" type="hidden" name="countOther"></p></div>
                                    <div>Other Incidents</div>
                                    <p style="font-size: 50px;"><?php echo $otherdataIndex['othertotal'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Counters -->

            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                 <div id="map" style="width:100%;height:500px;"></div>                     
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    
    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Locate fire station JavaScript -->
    <script src="../dist/js/fire-station-map.js"></script>

    <!-- Handle form submit event -->
    <script src='../dist/js/insert.js'></script>
    
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
                        callback.apply(this,[result]);
                    }
                }
            }
            rawFile.send(null)

    </script>

    <!-- Generate Google Maps API script tag -->
    <script>
        var mapsToken=result[1];
        var script = document.createElement('script');
        script.src = "https://maps.googleapis.com/maps/api/js?key="+mapsToken+"&libraries=places&callback=initMap";
        script.defer = true;
        document.getElementsByTagName('script')[0].parentNode.appendChild(script);
    </script>

    <!-- Keep Dropdown active -->
    <script type="text/javascript">
    $(document).ready(function(){
    $('.dropdown.keep-open').on({
        "shown.bs.dropdown": function() { this.closable = false; },
        "click":             function() { this.closable = true; },
        "hide.bs.dropdown":  function() { return this.closable; }
    });
     });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
        $("#submit").attr("disabled", "true");
        $("#fireStationAddress").blur(function(){
            if ($(this).val() != "") {
                $("#submit").removeAttr("disabled");
            } else {
                $("#submit").attr("disabled", "true");        
            }
        });    
    });
    </script>

    <!-- Hide alert -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#success-alert").hide();
            $("#danger-alert").hide();
        });

    </script>


</form>
<div class="container">
<!-- Cisco Webex Teams Chat window -->
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
    </div>

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

</body>

</html>
