@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> --}}
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('menutab')
<li role="presentation" class="dropdown">
	<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
		<i class="fa fa-user"></i>
		<span>Client Info</span>
		<span class="badge bg-green">{{-- Count of the cart --}}</span>
	</a>
	<ul id="menu1" class="width-350 dropdown-menu list-unstyled msg_list" role="menu">
		<li>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-10 col-sm-10 col-xs-12">
						<h3>{{ $client->fullname }}</h3>
					</div>
					<div class="col-md-2 col-sm-2 col-xs-12 nopadding">
						<img class="width-100-p" src="{{ urlImage('images/user.jpg') }}" alt="Profile Image" />
					</div>
				</div>
			</div>
			
			<span class="image">
			</span>
		</li>
		{{-- <li class="text-left">
			<label for="">Package Id : </label>
			<span>{{ $packageId }}</span>
		</li> --}}
		<li class="text-left">
			<div>
				<i class="fa fa-phone"> </i>
				<span>{{ $client->mobile }}</span>
			</div>
			<div>
				<i class="fa fa-envelope"> </i>
				<span>{{ $client->email }}</span>
			</div>
		</li>
		<li>
			<div><b>Message</b></div>
			<span>
				<div>
					{{ $client->note }}
				</div>
			</span>
		</li>
	</ul>
</li>
@endsection

@section('content')
	<div class="row">
		{{-- Hotel Serach --}}
		<div class="col-md-12">
			<div class="x_panel">
					<div class="x_title">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<h3>Make Activity Itinerary</h3>
						</div>
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content scroll-auto scroll-bar" >
						<div class="dashboard-widget-content">
							<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<a href="" onclick="event.preventDefault();
	                             document.getElementById('urlCopyHotelIti-form').submit();">
										<div class="height-200px font-size-30 vertical-parent">
											<div class="vertical-child">
												<div>
													<i class="fa fa-home font-size-80"></i>
													<i class="fa fa-long-arrow-right font-size-80"></i>
													<i class="fa fa-futbol-o font-size-80"></i>
												</div>
												<div class="m-top-10">Copy Hotel's Itinerary</div>
											</div>
										</div>
									</a>
	                
	                <form id="urlCopyHotelIti-form" action="{{ urlCopyHotelIti($urlVariable->id, $urlVariable->packageDbId) }}" method="POST" style="display: none;">
	                    {{ csrf_field() }}
	                </form>

								</div>
							</div>
							<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="tile-stats">
									<a href="{{ urlCopyHotelIti($urlVariable->id, $urlVariable->packageDbId) }}">
										<div class="height-200px font-size-30 vertical-parent">
											<div class="vertical-child">
												<div>
													<i class="fa fa-futbol-o font-size-80"></i>
												</div>
												<div class="m-top-10">Create Activities Itinerary</div>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
		{{-- /Hotel Serach --}}
	</div>

@endsection