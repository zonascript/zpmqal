@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
	<link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					@include($viewPath.'.show_partials.info')
					@include($viewPath.'.show_partials.follow_up')
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					@include($viewPath.'.show_partials.sector')
				</div>
			</div>
		</div>
	
		<div class="col-md-12 col-sm-12 col-xs-12">
			@include($viewPath.'.show_partials.routes')
		</div>

		{{-- Flights List --}}
		<a name="flights"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.show_partials.flights')
			</div>
		</div>
		{{-- /Flights List --}}


		{{-- Hotels List --}}
		<a name="hotels"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.show_partials.hotels')
			</div>
		</div>
		{{-- /Hotels List --}}

		{{-- Hotels List --}}
		<a name="cruises"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.show_partials.cruises')
			</div>
		</div>
		{{-- /Hotels List --}}
		

		{{-- Hotels List --}}
		<a name="cabs"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.show_partials.cars')
			</div>
		</div>
		{{-- /Hotels List --}}


		{{-- Activitiy List --}}
		<a name="activities"></a>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				@include($viewPath.'.show_partials.activities')
			</div>
		</div>
		{{-- /Activitiy List --}}

		{{-- Grand Total List --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-5 col-sm-5 col-xs-12">
					@include($viewPath.'.show_partials.costs')
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					@include($viewPath.'.show_partials.cost_history')
				</div>
			</div>
		</div>
		{{-- /Grand Total List --}}

	</div>


{{-- popUpModel --}}
@include('common.protected.dashboard.partials._popupModel')
{{-- /popUpModel --}}


@endsection

@section('js')

	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

@endsection


@section('scripts')
	@include($viewPath.'.show_partials._scripts')
@endsection