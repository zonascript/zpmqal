<?php

$html = 'var searchWord = \'\';
	appendHtml += \'<li class="min-height-110px">
	<div class="x_panel glowing-border">
		<div class="col-md-10 col-sm-10 col-xs-12">\';
		$.each(tripOption.slice, function(sliceKey,slice){
			$.each(slice.segment, function(segmentKey,segment){
				searchWord += airlines[segment.flight.carrier] +\' \'+segment.flight.carrier + segment.flight.number;
				appendHtml += \'<div class="row">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div class="row m-tb-10px text-left">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row">
									<img src="'.urlImage('images/airlineImages/').'\'+segment.flight.carrier+\'.gif" alt="">
								</div>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="flightName font-size-15">\'
									+airlines[segment.flight.carrier]+
								\'</div>
								<div>
									<small>\'+segment.flight.carrier + segment.flight.number+\'</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">\';
						$.each(segment.leg, function(legKey,leg){
							appendHtml += \'<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text-center">
										<h2>
											<span>\'+getTime(leg.departureTime)+\'</span>
											<small>(\'+getDate(leg.departureTime)+\')</small>
										</h2>
										<div>\'+leg.origin+\'</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text-center">
										<h2>
											<span>\'+getTime(leg.arrivalTime)+\'</span>
											<small>(\'+getDate(leg.arrivalTime)+\')</small>
										</h2>
										<div>\'+leg.destination+\'</div>
									</div>
								</div>		
							</div>\';
						});
					appendHtml += \'</div>
				</div>\';
			});
		});
		appendHtml += \'</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<h2 class="flightPrice text-center">'.
					// {{-- <i class="fa fa-rupee"></i> --}}
					// {{-- <span>{{ ifset($tripOption->saleTotal) }}</span> --}}
					// {{-- <span>/-</span> --}}
				'</h2>
				<div class="search-word" hidden>\'+searchWord+\'</div>
				<div class="row m-tb-20px">
					<button class="btn btn-primary btn-block btn-addtocart" data-elemid="\'+ids.elem_id+\'" data-did="\'+ids.did+\'" data-id="\'+tripOptionKey+\'" data-vendor="qpx">Select</button>
				</div>
			</div>
		</div>
	</li>\';';

	$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html))); 

?>

{{-- did == db id --}}
<script>
	function postQpxFlight(did = '', rid ='') {
		var elem_id = "flight_"+rid;
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
		<?php echo $html; ?> 
		return appendHtml;
	}

	function getDate(datetime) {
		return moment(datetime).format("DD-MM-YYYY");
	}

	function getTime(datetime) {
		return moment(datetime).format("HH:mm");
	}
	
</script>

