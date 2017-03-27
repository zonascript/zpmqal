@extends('common.protected.dashboard.main')

@section('customCss')
	<link href="{{ asset('b2b/css/custom.min.css') }}" rel="stylesheet">
@endsection

@section('beforecontent')
	@include('b2b.protected.dashboard.partials._to_do')
@endsection

@section('_nav_left')
	@include('b2b.protected.dashboard.partials._nav_left')
@endsection

@section('_nav_top')
	@include('b2b.protected.dashboard.partials._nav_top')
@endsection

@section('once_scripts')
	<script>
		var csrf_token = $('[name="csrf_token"]').attr('content');
	</script>
@endsection

@section('b2b_scripts')
	@include('b2b.protected.dashboard.partials._scripts')
@endsection

