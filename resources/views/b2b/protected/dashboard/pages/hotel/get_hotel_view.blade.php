@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
  {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
  <link rel="stylesheet" href="{{ url('css/redirect.css') }}">

@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection

@section('content')
	<div id="loging_log">
		<div id="fgfpreloader" class="fixed-top"></div>
		<i id="logo" class="s-icon-fgf font-big fixed-top"></i>
	</div>
	<div class="row">
		{{-- Hotel Serach --}}
		{{-- @include('b2b.protected.dashboard.pages.hotel.partials.content_hotelsearch') --}}
		{{-- /Hotel Serach --}}
		
		{{-- Hotels Body  --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div id="hotelResult">
				<div class="row">	
					{{-- Hotel Serach --}}
					@include('b2b.protected.dashboard.pages.hotel.get_hotel_view_partials._filter')
					{{-- /Hotel Serach --}}
				</div>
				<div class="row">
					<ul id="hotelResultStack" class="list list-unstyled">
						<li hidden></li>
						{{-- <li class="m-top-10">
							<div class="x_panel glowing-border nopadding">
								<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
									<div class="col-md-3 col-sm-3 col-xs-12 nopadding">
										<div class="col-md-11 col-sm-11 col-xs-12 nopadding height-150px">
											<img src="http://d3ba47lalua02r.cloudfront.net/available/90365593/rmc.jpg" alt="" height="100%" width="100%">
										</div>
									</div>
									<div class="col-md-7 col-sm-7 col-xs-12">
										<h2>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<h3 class="nopadding hotelName">Oasia Hotel Novena, Singapore By Far East Hospitality</h3>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12 ">
												<div class="col-md-4 col-sm-4 col-xs-4 m-top-5 nopadding">
													<i class="fa fa-star font-gold font-size-13"></i><i class="fa fa-star font-gold font-size-13"></i><i class="fa fa-star font-gold font-size-13"></i><i class="fa fa-star font-gold font-size-13"></i><i class="fa fa-star font-gold font-size-13"></i>
													<div hidden="">
														<p class="starRating">4</p>
													</div>
												</div>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12 m-top-5 font-size-13">
												<b>Amenities : </b>Coffee maker, Satellite TV, Front desk 24 hour, Laundry, Air conditioning, Lift, Wi-Fi, Hairdryer, Safe deposit box, Bar, Daily newspaper
											</div>
										</h2>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
												<div class="fixed-tooltip btn-block">
													<span class="fixed-tooltiptext font-size-10 bg-color-lightcoral">All NIGHT PRICE</span>
												</div>
												<h3 class="text-center m-top-5">
													<i class="fa fa-rupee font-size-20"></i>
													<span class="hotelPrice">0</span>
												</h3>
											</div>
											<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
												<input type="button" class="btn btn-primary btn-block btn-chooseRoom" value="Choose Room" data-hotelindex="0" data-vendor="tbtq">
											</div>
										</div>
									</div>
								</div>
								<div id="hoteldetail-ss_0" class="col-md-12 col-sm-12 col-xs-12 nopadding classHotelDetail" style="display: none;">
									<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
										<div id="exTab1" class="container">
											<ul class="nav nav-pills">
												<li class="col-md-2 col-sm-2 col-xs-12 text-center active ">
													<a href="#ss_0-ss_0a" data-toggle="tab">Rooms</a>
												</li>
												<li class="col-md-2 col-sm-2 col-xs-12 text-center">
													<a href="#ss_0-ss_01a" data-toggle="tab">About</a>
												</li>
												<li class="col-md-2 col-sm-2 col-xs-12 text-center">
													<a href="#ss_0-ss_02a" data-toggle="tab">Map</a>
												</li>
												<li class="col-md-2 col-sm-2 col-xs-12 text-center">
													<a href="#ss_0-ss_03a" data-toggle="tab">Gallary</a>
												</li>
											</ul>
											<div id="main_hotelDetail_ss_0" class="tab-content main-hotelDetail scroll-bar clearfix">
												<div class="tab-pane active" id="ss_0-ss_0a">
													<div id="roomresult-ss_0" class="row"></div>
												</div>
												<div class="tab-pane" id="ss_0-ss_01a"></div>
												<div class="tab-pane" id="ss_0-ss_02a"></div>
												<div class="tab-pane" id="ss_0-ss_03a"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li> --}}
					</ul>
				</div>
			</div>
		</div>
		{{-- /Hotels Body  --}}
	</div>
	
	@include('b2b.protected.dashboard.pages.hotel.partials.content_hidden')

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	{{-- list.js --}}
	<script src="{{ asset('js/list.min.js') }}"></script>
	{{-- /list.js --}}
		
@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.hotel.get_hotel_view_partials._scripts')
@endsection