<ul class="list list-unstyled">
	<li class="min-height-110px">
		<div class="x_panel glowing-border">
			<div class="col-md-10 col-sm-10 col-xs-12">
				@foreach ($flightRoute->flightDetail() as $flightDetail)
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-12">
							<div class="row m-tb-10px">
								<div class="col-md-12 col-sm-12 col-xs-12 text-left">
									<div class="row">
										<div class="col-md-3 col-sm-3 col-xs-12">
											<div class="row">
												<img src="{{ urlImage('images/airlineImages/'.$flightDetail->code.'.gif') }}" alt="">
											</div>
										</div>
										<div class="col-md-9 col-sm-9 col-xs-12">
											<div class="flightName font-size-15">
												{{ str_replace('Limited', '', $flightDetail->name)  }}
											</div>
											<div>
												<small>
													{{ $flightDetail->code.$flightDetail->flightNumber }}
												</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-7 col-sm-7 col-xs-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text-center">
										<h2>
											{{ $flightDetail->departureTime }} 
											<small>({{ $flightDetail->departureDate }})</small>
										</h2>
										<div>
											{{ $flightDetail->origin }} 
											<small>({{ $flightDetail->originCode }})</small>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="text-center">
										<h2>
											{{ $flightDetail->arrivalTime }} 
											<small>({{ $flightDetail->arrivalDate }})</small>
										</h2>
										<div>
											{{ $flightDetail->destination }} 
											<small>({{ $flightDetail->destinationCode }})</small>
										</div>
									</div>
								</div>		
							</div>	
						</div>
					</div>
				@endforeach
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<h2 class="flightPrice text-center">
					{{-- <i class="fa fa-rupee"></i> --}}
					{{-- <span>{{ ifset($tripOption->saleTotal) }}</span> --}}
					{{-- <span>/-</span> --}}
				</h2>
				{{-- <div class="row m-tb-20px">
					<a href="{{ urlFlightsResult($flightRoute->flight->id) }}" class="btn btn-primary btn-block btn-bookFlight">Change</a>
				</div> --}}
			</div>
		</div>
	</li>
</ul>