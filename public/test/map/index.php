<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-IDStnRaA8ueCCENLDL_s0nCzehhTrF0&sensor=false"></script> -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyC-IDStnRaA8ueCCENLDL_s0nCzehhTrF0"></script>
<script type="text/javascript">

// var geocoder = new google.maps.Geocoder();
// var address = "new york";

// geocoder.geocode( { 'address': address}, function(results, status) {

//   if (status == google.maps.GeocoderStatus.OK) {
//     var latitude = results[0].geometry.location.lat();
//     var longitude = results[0].geometry.location.lng();
//     alert(latitude);
//   } 
// }); 

</script>

<script type="text/javascript">
	google.maps.event.addDomListener(window, 'load', intilize);
	
	function intilize() {
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById("txtautocomplete"));

		google.maps.event.addListener(autocomplete, 'place_changed', function () {

			var place = autocomplete.getPlace();
			var location = "Address: " + place.formatted_address + "<br/>";
			location += "Latitude: " + place.geometry.location.lat() + "<br/>";
			location += "Longitude: " + place.geometry.location.lng();
			// document.getElementById('lblresult').innerHTML = location
			
			// document.getElementById('mapIframe').innerHTML = '<iframe width="100%" height="290" src = "https://maps.google.com/maps?q='+place.geometry.location.lat()+','+place.geometry.location.lng()+'&hl=es;z=14&amp;output=embed"></iframe>';
		});
	};
</script>

<span>location:</span><input type="text" id="txtautocomplete" style="width:200px" placeholder="enter the adress"/>
<label id="lblresult"></label>
<div id="mapIframe">
</div>

<iframe width="100%" height="290" src = "https://maps.google.com/maps?q=1.3553794,103.8677444/@14.2773889,72.0872807&hl=es;z=14&amp;output=embed"></iframe>
<!-- To use Geocoding from Google Maps V3 you need to link https://maps.googleapis.com/maps/api/js?sensor=false -->
<div>
		 <h3> Enter an adress and press the button</h3>

		<input id="address" type="text" placeholder="Enter address here" />
		<button id="btn">Get LatLong</button>
		<div>
				<p>Latitude:
						<input type="text" id="latitude" readonly />
				</p>
				<p>Longitude:
						<input type="text" id="longitude" readonly />
				</p>
		</div>
</div>

<script>
	/* This showResult function is used as the callback function*/

	function showResult(result) {
			document.getElementById('latitude').value = result.geometry.location.lat();
			document.getElementById('longitude').value = result.geometry.location.lng();
	}

	function getLatitudeLongitude(callback, address) {
			// If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
			address = address || 'Ferrol, Galicia, Spain';
			// Initialize the Geocoder
			geocoder = new google.maps.Geocoder();
			if (geocoder) {
					geocoder.geocode({
							'address': address
					}, function (results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
									callback(results[0]);
							}
					});
			}
	}

	var button = document.getElementById('btn');

	button.addEventListener("click", function () {
			var address = document.getElementById('address').value;
			getLatitudeLongitude(showResult, address)
	});
</script>
</body>
</html>