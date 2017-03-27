<ul class="list list-unstyled">
	{{-- foreach here  --}}
	@if(isset($flightsResult->trips->tripOption))
		@forelse($flightsResult->trips->tripOption as $tripOptionKey => $tripOption)
			<li class="min-height-110px">
				<div class="x_panel glowing-border">
					<div class="col-md-10 col-sm-10 col-xs-12">
						@foreach ($tripOption->slice as $slice)
							@foreach ($slice->segment as $segment)
								<?php 
									$carrierCode = ifset($segment->flight->carrier);
									$carrierNumber = ifset($segment->flight->number);
									$carrierName = ifset($flightsResult->airline->$carrierCode);
								?>
								<div class="row">
									<div class="col-md-5 col-sm-5 col-xs-12">
										<div class="row m-tb-10px">
											<div class="col-md-12 col-sm-12 col-xs-12 text-left">
												<div class="row">
													<div class="col-md-3 col-sm-3 col-xs-12">
														<div class="row">
															<img src="{{ urlImage('images/airlineImages/'.$carrierCode.'.gif') }}" alt="">
														</div>
													</div>
													<div class="col-md-9 col-sm-9 col-xs-12">
														<div class="flightName font-size-15">
															{{ str_replace('Limited', '', $carrierName)  }}
														</div>
														<div>
															<small>
																{{ $carrierCode.$carrierNumber }}
															</small>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-7 col-sm-7 col-xs-12">
										@foreach ($segment->leg as $leg)
											<?php 
												$origin = $leg->origin;
												$destination = $leg->destination;
												$departureDateTime = getDateTime($leg->departureTime);
												$arrivalDateTime = getDateTime($leg->arrivalTime);
											?>
											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="text-center">
														<h2>
															{{ ifset($departureDateTime->time) }} 
															<small>({{ ifset($departureDateTime->date) }})</small>
														</h2>
														<div>
															{{ $origin }} 
															<small>({{ifset($flightsResult->cities->$origin)}})</small>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="text-center">
														<h2>
															{{ ifset($arrivalDateTime->time) }} 
															<small>({{ ifset($arrivalDateTime->date) }})</small>
														</h2>
														<div>
															{{ $destination }} 
															<small>({{ifset($flightsResult->cities->$destination)}})</small>
														</div>
													</div>
												</div>		
											</div>	
										@endforeach
									</div>
								</div>
							@endforeach
						@endforeach
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h2 class="flightPrice text-center">
							{{-- <i class="fa fa-rupee"></i> --}}
							{{-- <span>{{ ifset($tripOption->saleTotal) }}</span> --}}
							{{-- <span>/-</span> --}}
						</h2>
						<div class="row m-tb-20px">
							<button class="btn btn-primary btn-block btn-bookFlight" 
								data-bookIndex="{{$tripOptionKey}}" data-vendor="qpx">Select</button>
						</div>
					</div>
				</div>
			</li>
		@empty
			<li class="min-height-110px"><h1>No Result Found</h1></li>
		@endforelse
	@else
		<li class="min-height-110px"><h1>No Result Found</h1></li>
	@endif
	{{-- /foreach  --}}
</ul>