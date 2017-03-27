@forelse ($package->cruises->cruisesResult as $cruisesResultKey => $cruisesResult)
	@if (bool_object($cruisesResult))
		<li class="m-top-10">
			<div class="x_panel glowing-border nopadding">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
							<img src="{{ ifset($cruisesResult->images[0], urlDefaultImageCruise()) }}" alt="" height="100%" width="100%">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<h2>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h3 class="nopadding hotelName">{{ ucwords(strtolower(ifset($cruisesResult->cruiseName))) }}</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
								<i class="fa fa-map-marker"></i>
								<span>{{ ifset($cruisesResult->address) }}</span> 
								{{-- <span> | </span> 
								<span>
									<a id="btn-showMap" class="btn-link cursor-pointer">Map</a>
								</span> --}}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="m-top-5 nopadding">
									{!! starRating(ifset($cruisesResult->starRating,0)) !!} | 
									<span class="font-size-13">
										<b>Check In : </b>{{ date_formatter(ifset($cruisesResult->checkInDate),'Y-m-d','d-M-Y') }} | <b>Check Out : </b>{{ date_formatter(ifset($cruisesResult->checkOutDate),'Y-m-d','d-M-Y') }}
									</span>
									<div hidden>
										<p class="starRating" >{{ ifset($cruisesResult->starRating,0) }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-15 font-size-13">
								{{ sub_string(strip_tags(ifset($cruisesResult->description)), 120) }}
								<button 
									id="btn-amenitiesMore" 
									class="btn-link cursor-pointer btn-model" 
									data-toggle="modal" 
									data-target=".bs-example-modal-lg" 
									data-title="{{ ucwords(strtolower(ifset($cruisesResult->cruiseName))) }} : Description" 
									data-bodyid="hotelDescription{{ $cruisesResultKey }}" 
									data-button="false">More
								</button>
								<div id="hotelDescription{{ $cruisesResultKey }}" hidden>
									{!! str_replace('<b>', '<b class="capitalize">', $cruisesResult->description) !!}
								</div>
							</div>

						</h2>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12">
						<div class="row">

							<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
								{{-- <div class="col-md-12 col-sm-11 col-xs-12"> --}}
									<div class="fixed-tooltip btn-block">
										<span class="fixed-tooltiptext font-size-10 bg-color-lightcoral">All NIGHT PRICE</span>
									</div>
									<h3 class="text-center m-top-5">
										<i class="fa fa-rupee font-size-20"></i>
										<span class="hotelPrice">{{ $cruisesResult->roomPrice }}</span>
									</h3>
								{{-- </div> --}}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
								{{-- <div class="col-md-12 col-sm-12 col-xs-12 pull-right nopadding"> --}}
								<a href="{{ urlCruisesBuilder($cruisesResult->this_id) }}" class="btn btn-primary btn-block" >Change Hotel</a>
								{{-- </div> --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
	@endif
@empty
	<p>No Result Found</p>
@endforelse