{{-- Hotel Result --}}
<ul class="list list-unstyled">
	@forelse ($cruiseResults as $cruiseResult_key => $cruiseResult)
		<li class="m-top-10">
			<div class="x_panel glowing-border nopadding">
				<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
					<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
						<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
							<img src="{{ isset($cruiseResult->images[0]) ? $cruiseResult->images[0] : urlDefaultImageHotel()  }}" alt="" height="100%" width="100%">
						</div>
					</div>
					<div class="col-md-7 col-sm-7 col-xs-12">
						<h2>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h3 class="nopadding hotelName">
									{{ ucwords(strtolower($cruiseResult->cruiseName)) }}
								</h3>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
								<i class="fa fa-map-marker"></i>
								<span>{{ sub_string($cruiseResult->address, 40) }}</span> 
								<span> | </span> 
								<span>
									<a id="btn-showMap" class="btn-link cursor-pointer">Map</a>
								</span>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 ">
								<div class="col-md-4 col-sm-4 col-xs-4 m-top-5 nopadding">
									{!! starRating($cruiseResult->starRating) !!}
									<div hidden>
									<p class="starRating" >{{ $cruiseResult->starRating }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
								{{ sub_string($cruiseResult->description, 120) }}
								<button id="btn-amenitiesMore" class="btn-link cursor-pointer" 
									data-toggle="modal" data-target=".bs-example-modal-sm" 
									data-title="{{ ucwords(strtolower($cruiseResult->cruiseName)) }} : Description" data-bodyid="hotelDescription{{ $cruiseResult_key }}" 
									data-button="false">More
								</button>
								<div id="hotelDescription{{ $cruiseResult_key }}" hidden>
									{{ $cruiseResult->description }}
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
										<span class="hotelPrice">{{ $cruiseResult->promotionRoomPrice != '' ? $cruiseResult->promotionRoomPrice : $cruiseResult->roomPrice }}</span>
									</h3>
								{{-- </div> --}}
							</div>
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
								{{-- <div class="col-md-12 col-sm-12 col-xs-12 pull-right nopadding"> --}}
								<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Choose Room" data-cruiseIndex="{{ $cruiseResult_key }}" />
								{{-- </div> --}}
							</div>
						</div>
					</div>
				</div>
				{{-- Hotel Rooms --}}
				<div id="hoteldetail-{{ $cruiseResult_key }}" class="col-md-12 col-sm-12 col-xs-12 nopadding classHotelDetail" style="display: none;">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
						<div id="exTab1" class="container">
							<ul  class="nav nav-pills">
								<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
									<a  href="#{{ $cruiseResult_key.'_'.$cruiseResult_key }}a" data-toggle="tab">Rooms</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $cruiseResult_key.'_'.($cruiseResult_key+1) }}a" data-toggle="tab">About</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $cruiseResult_key.'_'.($cruiseResult_key+2) }}a" data-toggle="tab">Map</a>
								</li>
								<li class="col-md-2 col-sm-2 col-xs-12 text-center">
									<a href="#{{ $cruiseResult_key.'_'.($cruiseResult_key+3) }}a" data-toggle="tab">Gallary</a>
								</li>
							</ul>
							<div class="tab-content main-hotelDetail scroll-bar clearfix">
								<div class="tab-pane active" id="{{ $cruiseResult_key.'_'.$cruiseResult_key }}a">
									<div id="roomresult-{{ $cruiseResult_key }}" class="row">
										{{-- hotel room post data will show here --}} 
									</div>
								</div>
								<div class="tab-pane" id="{{ $cruiseResult_key.'_'.($cruiseResult_key+1) }}a">
									<h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
								</div>
								<div class="tab-pane" id="{{ $cruiseResult_key.'_'.($cruiseResult_key+2) }}a">
									<h3>klasdf adsfkf We applied clearfix to the tab-content to rid of the gap between the tab and the fds dfskg content</h3>
								</div>
								<div class="tab-pane" id="{{ $cruiseResult_key.'_'.($cruiseResult_key+3) }}a">
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