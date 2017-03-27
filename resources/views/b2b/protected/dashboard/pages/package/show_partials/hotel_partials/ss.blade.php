<?php 
	$hotel = $hotelRoute->hotel;
	$skyscannerHotels = $hotel->skyscannerHotel->result;
	$hotelDetail = $hotel->skyscannerHotel->hotelDetail->result;
	$skyscannerHotel = null;
	$images = [urlDefaultImageHotel()];

	if (isset($skyscannerHotels->hotels[$hotel->skyscannerHotel->selected_index])) {
		$skyscannerHotel = $skyscannerHotels->hotels[$hotel->skyscannerHotel->selected_index];
		$images = ssImageArrayFix($skyscannerHotel->images, $skyscannerHotels->image_host_url);
	}
?>
@if(!is_null($skyscannerHotel))

<ul class="list list-unstyled">
	<?php $uniqueKey = 'ss_'.$hotel->skyscannerHotel->selected_index; ?>
	<li class="m-top-10">
		<div class="x_panel glowing-border nopadding">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
					<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
						<img src="{{ $images[0] }}" alt="" height="100%" width="100%">
					</div>
				</div>
				<div class="col-md-9 col-sm-9 col-xs-12">
					<h2>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="nopadding hotelName">{{ ucwords(strtolower($skyscannerHotel->name)) }}</h3>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							<i class="fa fa-map-marker"></i>
							<span>{{ str_replace(', ,', ',', $hotelDetail->hotels[0]->address) }}</span> 
							{{-- <span> | </span> 
							<span>
								<a id="btn-showMap" class="btn-link cursor-pointer">Map</a>
							</span> --}}
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 ">
							{!! starRating($skyscannerHotel->star_rating) !!}
							<div hidden>
								<p class="starRating" >{{ $skyscannerHotel->star_rating }}</p>
							</div>
							<span class="font-size-13">
								 | <b>Check In : </b>
								{{ date_formatter($hotelRoute->start_date,'Y-m-d H:i:s','d-M-Y') }}
								 | <b>Check Out : </b>
								{{ date_formatter($hotelRoute->end_date,'Y-m-d H:i:s','d-M-Y') }}
							</span>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
							{{ sub_string($hotelDetail->hotels[0]->description, 120) }}
							<button 
								id="btn-amenitiesMore" 
								class="btn-link cursor-pointer btn-model" 
								data-toggle="modal" 
								data-target=".bs-example-modal-lg"
								data-title="{{ ucwords(strtolower($skyscannerHotel->name)) }} : Description" data-bodyid="hotelDescription{{ $uniqueKey }}" 
								data-button="false">More
							</button>
							<div id="hotelDescription{{ $uniqueKey }}" hidden>
								{!! $hotelDetail->hotels[0]->description !!}
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
									<span class="hotelPrice">{{ $skyscannerHotel->Price->PublishedPriceRoundedOff }}</span>
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
								<a  href="#{{ $uniqueKey.'_'.$uniqueKey }}a" data-toggle="tab">Rooms</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey.'_'.$uniqueKey.'1' }}a" data-toggle="tab">About</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey.'_'.$uniqueKey.'2' }}a" data-toggle="tab">Map</a>
							</li>
							<li class="col-md-2 col-sm-2 col-xs-12 text-center">
								<a href="#{{ $uniqueKey.'_'.$uniqueKey.'3' }}a" data-toggle="tab">Gallary</a>
							</li>
						</ul>
						<div class="tab-content main-hotelDetail scroll-bar clearfix">
							<div class="tab-pane active" id="{{ $uniqueKey.'_'.$uniqueKey }}a">
								<div id="roomresult-{{ $uniqueKey }}" class="row">
									{{-- hotel room post data will show here --}} 
								</div>
							</div>
							<div class="tab-pane" id="{{ $uniqueKey.'_'.$uniqueKey.'1' }}a">
								<h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
							</div>
							<div class="tab-pane" id="{{ $uniqueKey.'_'.$uniqueKey.'2' }}a">
								<h3>klasdf adsfkf We applied clearfix to the tab-content to rid of the gap between the tab and the fds dfskg content</h3>
							</div>
							<div class="tab-pane" id="{{ $uniqueKey.'_'.$uniqueKey.'3' }}a">
								<h3>We use css to change the background color of the content to be equal to the tab</h3>
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
