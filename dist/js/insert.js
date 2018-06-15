$('#myform').on('submit', function(e) {
     $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(html) {
            alert("Incident created");
            $('#myform')[0].reset();
        }
    });
    e.preventDefault();
});

$('#fireStationForm').on('submit', function(e) {
     $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(html) {
            $('#fireStationForm')[0].reset();
        }
    });
    e.preventDefault();
});

$('#fireStationForm2').on('submit', function(e) {
     $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(html) {
         alert("Incedent fetched and ready to track");
        }
    });
});

$('#sparkform').on('submit', function(e) {
     $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(html) {
            $('#sparkform')[0].reset();
        }
    });
    e.preventDefault();
});

function yourFunction(){
	var incidentName =  document.getElementById("incident").value;
	var type = document.getElementById("type").value;
	var address = document.getElementById("address").value;
	var location = document.getElementById("location").value;
	var severe = document.getElementById("severe").value;
	var desc = document.getElementById("desc").value;
	var callerName = document.getElementById("callerName").value;
	var callerph = document.getElementById("callerph").value;
	var fireStationAddress = document.getElementById("fireStationAddress").value;

    var action_src = "http://localhost/insertIncidents?incident_name="+encodeURIComponent(incidentName)+"&type="+encodeURIComponent(type)+"&address="+encodeURIComponent(address)+"&location="+encodeURIComponent(location)+"&severe="+encodeURIComponent(severe)+"&desc="+encodeURIComponent(desc)+"&callerName="+encodeURIComponent(callerName)+"&callerph="+encodeURIComponent(callerph)+"&fireStationAddress="+encodeURIComponent(fireStationAddress);
    var your_form = document.getElementById('myform');
    your_form.action = action_src ;
}