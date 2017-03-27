{{--Flight Result --}}

<ul class="list list-unstyled">
	{{-- foreach here  --}}
	@if(isset($flightsResult->trips))
		@forelse($flightsResult->trips->tripOption as $tripOption_key => $tripOption)
			<li class="min-height-110px">
				<div class="x_panel glowing-border">
					<div class="col-md-4 col-sm-4 col-xs-12">
						<div class="row m-tb-10px">
							<div class="col-md-12 col-sm-12 col-xs-12 text-left">
								@foreach ($tripOption->flightInfo as $flightInfo)
									@foreach ($flightInfo->flights->airline as $airline_key => $airline_value)
										<div class="row">
											<div class="col-md-3 col-sm-3 col-xs-12">
												<div class="row">
													<img src="{{ urlImage('images/airlineImages/'.ifset($airline_value->carrier).'.gif') }}" alt="">
												</div>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<div class="flightName font-size-15">{{ str_replace('Limited', '', ifset($airline_value->name))  }}</div>
												<div>
													<small>
														{{ $airline_key.implode(', '.ifset($airline_value->carrier), ifset($airline_value->number)) }}
													</small>
												</div>
											</div>
										</div>
									@endforeach
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="col-md-7 col-sm-7 col-xs-12 nopadding">

							@foreach ($tripOption->flightInfo as $flightInfo)
								<?php 
									$dateTimeCount = count($flightInfo->dateTime); 
									$departureDateTime = getDateTime($flightInfo->dateTime[0]->departureTime);
									$arrivalDateTime = getDateTime($flightInfo->dateTime[$dateTimeCount-1]->arrivalTime);
								?>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
										<div><h2>{{ ifset($departureDateTime->time) }}</h2></div>
										<div><small>{{ ifset($departureDateTime->date) }}</small></div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
										<div><h2>{{ ifset($arrivalDateTime->time) }}</h2></div>
										<div><small>{{ ifset($arrivalDateTime->date) }}</small></div>
									</div>		
								</div>	
							@endforeach
						</div>

						<div class="col-md-5 col-sm-5 col-xs-12 m-top-20">
							{{-- <div><h2>16h 10m <small>1 stop</small></h2></div> --}}
							{{-- <div>DEL → MAA → SIN</div> --}}
							@foreach ($tripOption->flightInfo as $flightInfo)
								<div>{{ str_replace('|', ' → ', ifset($flightInfo->stops)) }}</div>
							@endforeach
						</div>

					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<h2 class="flightPrice text-center">
							<i class="fa fa-rupee"></i>
							<span>{{ ifset($tripOption->totalCost->inInr) }}</span>
							<span>/-</span>
						</h2>
						<div class="row m-tb-10px">
							<button class="btn btn-primary btn-block btn-bookFlight" 
								data-bookIndex="{{$tripOption_key}}">Select</button>
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
{{-- /Flight Result --}}