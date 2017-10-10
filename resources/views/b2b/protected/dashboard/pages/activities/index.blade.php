@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/builder_spin.css') }}">
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	{{-- <link rel="stylesheet" type="text/css" id="u0" href="https://cdn.tinymce.com/4/skins/lightgray/skin.min.css"> --}}
	<link rel="stylesheet" href="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.css') }}">

@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection

@section('content')
	<div class="btn-right-top cursor-pointer" data-toggle="modal" data-target=".bs-example-modal-to-do">
		
	</div>
	<div id="rid_result" class="row">
		<div class="col-md-3 col-md-3 col-xs-12">
			<div class="row">	
				<div class="x_panel nopadding" style="background: aliceblue;">
					<h3><div class="text-center">Activities</div></h3>
				</div>
			</div>
			@include($viewPath.'.partials._filter')
			<div class="row m-top-70" align="center">
				<div id="saveActivities" class="circle-big bg-blue glowing-green-border cursor-pointer" data-rid="" data-did="">
					<div class="circle-in text-center font-size-20">Next <i class="fa fa-arrow-right"></i></div>
				</div>
			</div>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div id="exTab1" class="container">
						<ul id="tab_menu" class="nav nav-pills">
							@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
								<li class="col-md-2 col-sm-2 col-xs-12 text-center li-menu-dest 
									{{ $hotelRouteKey == 0 ? 'active' : ''}}" 
									data-list="rid_{{ $hotelRoute->id }}_div">
									<a id="a_rid_{{ $hotelRoute->id }}" 
										href="#rid_{{ $hotelRoute->id }}_div" 
										data-rid="{{ $hotelRoute->id }}"
										class="a_tab_menu"
										data-toggle="tab">
										{{ $hotelRoute->destination_detail->destination.', '.$hotelRoute->destination_detail->country }}
									</a>
								</li>
							@endforeach
						</ul>
						<div class="tab-content tab-content-box clearfix">
							@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
								<div id="rid_{{ $hotelRoute->id }}_div" 
										class="tab-pane {{ $hotelRouteKey == 0 ? 'active' : ''}}">
									<ul id="rid_{{ $hotelRoute->id }}" class="list list-unstyled" data-rid="{{ $hotelRoute->id }}"></ul>
									<button class="btn btn-success add-own-activity" data-count="0"
										>Add your own Activity
									</button>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- @include($viewPath.'.partials._hidden') --}}

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script src="{{ asset('js/list.min.js') }}"></script>


	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	<script src="{{ commonAsset('dashboard/vendors/dropzone/dist/min/dropzone.min.js') }}"></script>

	<script src="{{ commonAsset('dashboard/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>

@endsection

@section('scripts')
	@include($viewPath.'.partials.scripts._scripts')
@endsection