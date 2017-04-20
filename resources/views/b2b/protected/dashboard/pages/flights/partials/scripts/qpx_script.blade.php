
{{-- did == db id --}}
<script>
	function postQpxFlight(rid ='') {
		var ridObject = getRidObject(rid);
		var elem_id = "flight_"+rid;
		var did = ridObject.did;
		var ids = {
				'did' : did,
				'rid' : rid,
				'vendor' : 'qpx',
				'elem_id' : elem_id
			};

		$.ajax({
			type:"post",
			url: "{{ url('qpx/flights/result') }}/"+did,
			data: { "_token" : csrf_token },

			success: function(responce, textStatus, xhr) {
					var responce = JSON.parse(responce);
					var fullhtml = '';
					$('#sorry_error').remove();
					if (responce.hasOwnProperty('trips') && responce.trips.hasOwnProperty('tripOption')) {
						var tripOption = responce.trips.tripOption;
						$.each(tripOption, function(i,v){
							fullhtml = makeQpxHtml(i, v, responce, ids);
							$('#'+elem_id).append(fullhtml);
						});
					}else{
						/*refreashFlights(ids);*/
					}
					dataIsPulled(rid);					
					filter.initFilter(rid);
					
					$('#loging_log').hide();
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				else if(xhr.status == 500){
					$('#loging_log').hide();
					/*refreashFlights(ids);*/
				}
			}
		});
	}

</script>



<script>
	function makeQpxHtml(tripOptionKey, tripOption, data, ids) {
		var appendHtml = '';
		var airlines = data.airlines;
		var cities = data.cities;
		var stacks = [];

		$.each(tripOption.slice, function(sliceKey,slice){
			$.each(slice.segment, function(segmentKey,segment){
				var stack = {};
				stack['name'] = airlines[segment.flight.carrier].replace('Limited', '');
				stack['code'] =	segment.flight.carrier;
				stack['flightNumber'] = segment.flight.number;

				$.each(segment.leg, function(legKey,leg){
					var departureDateTime = qpxDateTime(leg.departureTime);
					stack['departureTime'] = departureDateTime.time;
					stack['departureDate'] = departureDateTime.date;			
					
					var arrivalDateTime = qpxDateTime(leg.arrivalTime);
					stack['arrivalTime'] = arrivalDateTime.time;
					stack['arrivalDate'] = arrivalDateTime.date;

					stack['origin'] = cities[leg.origin];
					stack['originCode'] = leg.origin;
					stack['destination'] = cities[leg.destination];
					stack['destinationCode'] = leg.destination;
				});
				stacks.push(stack);
			});
		});

		var flight = {
				'index' : tripOptionKey,
				'vendor_id': data.db.id,
				'stacks' : stacks, 
				'vendor' : 'qpx',
				'ids' : ids
			};

		return getFlightStack(flight);
	}
</script>

