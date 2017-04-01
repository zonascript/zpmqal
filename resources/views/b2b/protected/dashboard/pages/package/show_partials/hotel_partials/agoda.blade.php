<?php 
	$agodaHotel = isset($hotelRoute->hotel->agodaHotel)
				 			? $hotelRoute->hotel->agodaHotel 
				 			: null;

	$address = $agodaHotel->addressline1.', '.$agodaHotel->addressline2.', ZipCode - '.
						 $agodaHotel->zipcode.', '.$agodaHotel->city.', '.$agodaHotel->country;
	$address = str_replace(', ,', ',', $address);

	$images = $agodaHotel->photo1;
	$uniqueKey = 'a_'.$agodaHotel->hotel_id;
?>
@if(!is_null($agodaHotel))

<ul class="list list-unstyled">
	<li class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
					<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
						<img src="{{ $images }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="nopadding hotelName">{{ ucwords(strtolower($agodaHotel->hotel_name)) }}</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>{{ $address }}</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							{!! starRating($agodaHotel->star_rating) !!}
							<div hidden>
								<p class="starRating" >{{ $agodaHotel->star_rating }}</p>
							</div>
							<span class="font-size-13">
								 | <b>Check In : </b>
								{{ $hotelRoute->start_datetime->format('d-M-Y') }}
								 | <b>Check Out : </b>
								{{ $hotelRoute->end_datetime->format('d-M-Y') }}
							</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							{{ sub_string($agodaHotel->overview, 120) }}
							<button 
								id="btn-amenitiesMore" 
								class="btn-link cursor-pointer btn-model" 
								data-toggle="modal" 
								data-target=".bs-example-modal-lg"
								data-title="{{ ucwords(strtolower($agodaHotel->hotel_name)) }} : Description" data-bodyid="hotelDescription{{ $uniqueKey }}" 
								data-button="false">More
							</button>
							<div id="hotelDescription{{ $uniqueKey }}" hidden>
								{!! $agodaHotel->hotelDetail->details !!}
							</div>
						</div>

					</h2>
				</div>
				{{-- <div class="col-md-2 col-sm-2 col-xs-12"> --}}
					{{-- <div class="row"> --}}

						{{-- <div class="col-md-12 col-sm-12 col-xs-12 m-top-20"> --}}
							{{-- <div class="col-md-12 col-sm-11 col-xs-12"> --}}
								{{-- <div class="fixed-tooltip btn-block">
									<span class="fixed-tooltiptext font-size-10 bg-color-lightcoral">All NIGHT PRICE</span>
								</div>
								<h3 class="text-center m-top-5">
									<i class="fa fa-rupee font-size-20"></i>
									<span class="hotelPrice">{{ $agodaHotel->Price->PublishedPriceRoundedOff }}</span>
								</h3> --}}
							{{-- </div> --}}
						{{-- </div> --}}
						{{-- <div class="col-md-12 col-sm-12 col-xs-12 m-top-20"> --}}
							{{-- <input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Choose Room" data-hotelIndex="{{ $hotel->tbtqHotel->selected_index }}" data-vendor="tbtq" /> --}}
							{{-- <a href="{{ urlHotelsBuilder($hotel->id) }}" class="btn btn-primary btn-block" >Change Hotel</a> --}}
						{{-- </div> --}}
					{{-- </div> --}}
				{{-- </div> --}}
			</div>
			{{-- Hotel Rooms --}}
			<div id="hoteldetail-{{ $uniqueKey }}" class="col-md-12 col-sm-12 col-xs-12 nopadding classHotelDetail" style="display: none;">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
					<div id="exTab1" class="container">
						<ul  class="nav nav-pills">
							<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
								<a  href="#{{ $uniqueKey }}_rooms" data-toggle="tab">Rooms</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey }}_about" data-toggle="tab">About</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey }}_map" data-toggle="tab">Map</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey }}_gallary" data-toggle="tab">Gallary</a>
							</li>
						</ul>
						<div class="tab-content main-hotelDetail scroll-bar clearfix">
							<div class="tab-pane active" id="{{ $uniqueKey }}_rooms">
							</div>
							<div class="tab-pane" id="{{ $uniqueKey }}_about">
							</div>
							<div class="tab-pane" id="{{ $uniqueKey }}_map">
							</div>
							<div class="tab-pane" id="{{ $uniqueKey }}_gallary">
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- /Hotel Rooms --}}
		</div>
	</li>
</ul>
{{-- @else
	<u l><li class="min-height-110px"><h1>No Result Found</h1></li></ul>--}}
@endif
