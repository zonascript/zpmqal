<!DOCTYPE html>
<html>
<head>
	<title></title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
	function GetFlightDemo(){

		var data =	{
				"csrf_token": "aMpi8V8m129C-c5uDPYMEvA51A5-JDh4qq0LwDfwpHI6MTQ3MTk1NTE1Mjg1MzE3MA",
				"request": {
					"request": {
						"slice": [
							{
								"origin": "DEL",
								"destination": "SIN",
								"date": "2016-10-25"
							}
						],
						"passengers": {
							"adultCount": 1,
							"infantInLapCount": 0,
							"infantInSeatCount": 0,
							"childCount": 0,
							"seniorCount": 0
						},
						"solutions": 20,
						"refundable": false
					}
				}
			};

		var Stringdata = JSON.stringify(data);


		$.ajax({
			type: "POST",
			url: "https://qpx-express-demo.itasoftware.com/xhr",
			data: Stringdata,
			cache: false,
			success: function(html) {
				// openpopup('#getact-popup');
				$('#Result').empty();
				$('#Result').html(html);
			}
		});
	}

	function GetFlight(){
		
		var data =	{
			"request": {
					"slice": [
						{
							"origin": "DEL",
							"destination": "SIN",
							"date": "2016-10-25"
						}
					],
					"passengers": {
						"adultCount": 1,
						"infantInLapCount": 0,
						"infantInSeatCount": 0,
						"childCount": 0,
						"seniorCount": 0
					},
					"solutions": 20,
					"refundable": false
				}
			};

		var Stringdata = JSON.stringify(data);

		$.ajax({
			type: "POST",
			url: "https://www.googleapis.com/qpxExpress/v1/trips/search?key=AIzaSyAlixf2APl-GR-64eF2BVXXgzUuUOuNvlQ",
			data: Stringdata,
			contentType:"application/json; charset=utf-8",
			cache: false,
			success: function(html) {
				// openpopup('#getact-popup');
				// $('#Result').empty();
				var contact_data = JSON.stringify(html);
				jQuery('#Result').html(contact_data);
			}
		});
	}	

</script>
</head>
<body>
	<input type="submit" onclick="GetFlight()">
	<div id="Result"></div>
	<?php 
		// echo '{
		// 		"csrf_token": "aMpi8V8m129C-c5uDPYMEvA51A5-JDh4qq0LwDfwpHI6MTQ3MTk1NTE1Mjg1MzE3MA",
		// 		"request":"{
		// 			"request": {
		// 				"slice": [
		// 					{
		// 						"origin": "DEL",
		// 						"destination": "SIN",
		// 						"date": "2016-08-25"
		// 					}
		// 				],
		// 				"passengers": {
		// 					"adultCount": 1,
		// 					"infantInLapCount": 0,
		// 					"infantInSeatCount": 0,
		// 					"childCount": 0,
		// 					"seniorCount": 0
		// 				},
		// 				"solutions": 20,
		// 				"refundable": false
		// 			}
		// 		}"
		// 	}';



		// {
		// 		"request": {
		// 			"passengers": {
		// 				"kind": "qpxexpress#passengerCounts",
		// 				"adultCount": integer,
		// 				"childCount": integer,
		// 				"infantInLapCount": integer,
		// 				"infantInSeatCount": integer,
		// 				"seniorCount": integer
		// 			},
		// 			"slice": [
		// 				{
		// 					"kind": "qpxexpress#sliceInput",
		// 					"origin": string,
		// 					"destination": string,
		// 					"date": string,
		// 					"maxStops": integer,
		// 					"maxConnectionDuration": integer,
		// 					"preferredCabin": string,
		// 					"permittedDepartureTime": {
		// 						"kind": "qpxexpress#timeOfDayRange",
		// 						"earliestTime": string,
		// 						"latestTime": string
		// 					},
		// 					"permittedCarrier": [
		// 						string
		// 					],
		// 					"alliance": string,
		// 					"prohibitedCarrier": [
		// 						string
		// 					]
		// 				}
		// 			],
		// 			"maxPrice": string,
		// 			"saleCountry": string,
		// 			"ticketingCountry": string,
		// 			"refundable": boolean,
		// 			"solutions": integer
		// 		}
		// 	};
	?>
</body>
</html>
