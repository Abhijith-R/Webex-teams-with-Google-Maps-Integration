var map;
var infowindow;
var geocoder;
var lat = 12.9714885;
var long = 77.6115266;
var placeSearch, autocomplete;


function fireMap(lati,longi) {

  var bangalore = {lat:lati , lng: longi};

  map = new google.maps.Map(document.getElementById('map'), {
    center: bangalore,
    zoom: 14
  });

  infowindow = new google.maps.InfoWindow();
  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch({
    location: bangalore,
    radius: 5000,
    type: ['fire_station']
  }, callback);

  var marker = new google.maps.Marker({
  position: bangalore,
  icon: {
	path: google.maps.SymbolPath.CIRCLE,
	scale: 10
  },
  draggable: false,
  map: map
  });
}

function initMap() {

  var bangalore = {lat:lat , lng: long};

  map = new google.maps.Map(document.getElementById('map'), {
    center: bangalore,
    zoom: 12
  });

  infowindow = new google.maps.InfoWindow();
  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch({
    location: bangalore,
    radius: 8000,
    type: ['fire_station']
  }, callback);

  autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('address')),
      {types: ['geocode']});
}


function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

function createMarker(place) {
  var placeLoc = place.geometry.location;
  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name+"<br>"+ place.vicinity);
    document.getElementById("fireStationAddress").value =  place.vicinity;
    infowindow.open(map, this);
  });
}

function codeAddress() {
	var geocoder = new google.maps.Geocoder();
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
  	var latitude = results[0].geometry.location.lat();
	var longitude = results[0].geometry.location.lng();
	var addr = {lat: latitude, lng:longitude};
	var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: latitude, lng: longitude}
        });
	fireMap(latitude,longitude);
    });

  }

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}