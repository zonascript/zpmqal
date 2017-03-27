appendHtml += '<li class="min-height-110px main-list-item">
	<div class="x_panel glowing-border">
		<div class="col-md-10 col-sm-10 col-xs-12">';
		$.each(segmentsIds, function (segmentsId, segmentsVal) {

			if (data.Segments.hasOwnProperty(segmentsVal)) {
				var segment = data.Segments[segmentsVal];
				var flightName = data.Carriers[segment.Carrier].Name;
				var flightCode = data.Carriers[segment.Carrier].Code;
				var flightNumber = segment.FlightNumber;
				var departureDateTime = ssDateTime(segment.DepartureDateTime);
				var arrivalDateTime = ssDateTime(segment.ArrivalDateTime);
				var origin = data.Places[segment.OriginStation];
				var destination = data.Places[segment.DestinationStation];
				searchWord += ' '+flightName+' '+flightCode+flightNumber;

				appendHtml += '<div class="row">
					<div class="col-md-5 col-sm-5 col-xs-12">
						<div class="row m-tb-10px text-left">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="row">
									<img src="{{ urlImage('images/airlineImages/') }}'+flightCode+'.gif" alt="">
								</div>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<div class="flightName font-size-15">'+flightName+'</div>
								<div>
									<small>'+flightCode+flightNumber+'</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="text-center">
									<h2>
										<span>'+departureDateTime.time+'</span>
										<small>('+departureDateTime.date+')</small>
									</h2>
									<div>'+origin.Name+'
										<small>('+origin.Code+')</small>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="text-center">
									<h2>
										<span>'+arrivalDateTime.time+'</span>
										<small>('+arrivalDateTime.date+')</small>
									</h2>
									<div>'+destination.Name+'
										<small>('+destination.Code+')</small>
									</div>
								</div>
							</div>
						</div>';
					appendHtml += '</div>
				</div>';
			}
		});
		
		appendHtml += '</div>
		<div class="col-md-2 col-sm-2 col-xs-12">
			<div class="search-word" hidden>'+searchWord+'</div>
			<div class="row m-tb-20px">
				<button class="btn btn-primary btn-block btn-addtocart" data-elemid="'+ids.elem_id+'" data-did="'+ids.did+'" data-id="'+legKey+'" data-vendor="ss">Select</button>
			</div>
		</div>
	</div>
</li>';