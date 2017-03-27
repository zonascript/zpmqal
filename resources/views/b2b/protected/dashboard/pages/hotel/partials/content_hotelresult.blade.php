{{-- Hotel Result --}}
<ul class="list list-unstyled">
	@forelse ($hotelResults as $hotelResult_key => $hotelResult)
		<li class="m-top-10">
			<div class="x_panel glowing-border nopadding">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
							<img src="{{ isset($hotelResult['HotelPicture']) ? $hotelResult['HotelPicture'] : urlDefaultImageHotel()  }}" alt="" height="100%" width="100%">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<h2>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h3 class="nopadding hotelName">{{ ucwords(strtolower($hotelResult['HotelName'])) }}</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
								<i class="fa fa-map-marker"></i>
								<span>{{ sub_string($hotelResult['HotelAddress'], 40) }}</span> 
								<span> | </span> 
								<span>
									<a id="btn-showMap" class="btn-link cursor-pointer">Map</a>
								</span>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="col-md-4 col-sm-4 col-xs-4 m-top-5 nopadding">
									{!! starRating($hotelResult['StarRating']) !!}
									{{-- 
									<i class="fa fa-star font-gold font-size-13"></i>
									<i class="fa fa-star font-gold font-size-13"></i>
									<i class="fa fa-star font-gold font-size-13"></i>
									<i class="fa fa-star font-size-13"></i>
									<i class="fa fa-star font-size-13"></i> --}}
									<div hidden>
									<p class="starRating" >{{ $hotelResult['StarRating'] }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
								{{ sub_string($hotelResult['HotelDescription'], 120) }}
								<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
									data-toggle="modal" data-target=".bs-example-modal-sm" 
									data-title="{{ ucwords(strtolower($hotelResult['HotelName'])) }} : Description" data-bodyid="hotelDescription{{ $hotelResult_key }}" 
									data-button="false">More
								</button>
								<div id="hotelDescription{{ $hotelResult_key }}" hidden>
									{{ $hotelResult['HotelDescription'] }}
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
										<span class="hotelPrice">{{ $hotelResult['Price'] }}</span>
									</h3>
								{{-- </div> --}}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
								{{-- <div class="col-md-12 col-sm-12 col-xs-12 pull-right nopadding"> --}}
								<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Choose Room" data-hotelIndex="{{ $hotelResult_key }}" />
								{{-- </div> --}}
							</div>
						</div>
					</div>
				</div>
				{{-- Hotel Rooms --}}
				<div id="hoteldetail-{{ $hotelResult_key }}" class="col-md-12 col-sm-12 col-xs-12 nopadding classHotelDetail" style="display: none;">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
						<div id="exTab1" class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a  href="#{{ $hotelResult_key.'_'.$hotelResult_key }}a" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $hotelResult_key.'_'.($hotelResult_key+1) }}a" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $hotelResult_key.'_'.($hotelResult_key+2) }}a" data-toggle="tab">Map</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $hotelResult_key.'_'.($hotelResult_key+3) }}a" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div class="tab-content main-hotelDetail scroll-bar clearfix">
								<div class="tab-pane active" id="{{ $hotelResult_key.'_'.$hotelResult_key }}a">
									<div id="roomresult-{{ $hotelResult_key }}" class="row">
										{{-- hotel room post data will show here --}} 
									</div>
								</div>
								<div class="tab-pane" id="{{ $hotelResult_key.'_'.($hotelResult_key+1) }}a">
									<h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
								</div>
								<div class="tab-pane" id="{{ $hotelResult_key.'_'.($hotelResult_key+2) }}a">
									<h3>klasdf adsfkf We applied clearfix to the tab-content to rid of the gap between the tab and the fds dfskg content</h3>
								</div>
								<div class="tab-pane" id="{{ $hotelResult_key.'_'.($hotelResult_key+3) }}a">
									<h3>We use css to change the background color of the content to be equal to the tab</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- /Hotel Rooms --}}
			</div>
		</li>
	@empty
		<p>No Result Found</p>
	@endforelse
</ul>
{{-- /Hotel Result --}}