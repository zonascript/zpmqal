@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">

  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
  {{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
@endsection

{{-- @section('menutab')
	@include('b2b.protected.dashboard.pages.common.menu')
@endsection --}}

@section('content')
	<div class="row">
		{{-- {{ pre_echo($client) }} --}}
		{{-- {{ pre_echo($cartData) }} --}}
		{{-- {{ pre_echo($request) }} --}}
		{{-- {{ pre_echo($hotelResult) }} --}}
		{{-- Flight Serach --}}
		{{-- @include('admin.dashboard.pages.flight_partials.content_search') --}}
		{{-- /Flight Serach --}}
		
		{{-- Hotels Body  --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div id="flightsResult">
					<div class="row">
						{{-- Flight Result --}}
						{{-- {{ pre_echo($flightsResult) }} --}}
						@include('b2b.protected.dashboard.pages.activities.partials.content_result')
						{{-- /Flight Result --}}
					</div>
					<div class="row m-top-20">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a href="{{ urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}" class="btn btn-primary btn-block">Cancel</a>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<button id="saveActivities" class="btn btn-success btn-block">Save Activities</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- /Hotels Body  --}}
	</div>
	
	@include('b2b.protected.dashboard.pages.activities.partials.content_hidden')

@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>

	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	{{-- list.js --}}
	<script src="{{ asset('js/list.min.js') }}"></script>
	{{-- /list.js --}}
		
@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.activities.partials.content_scripts')
@endsection