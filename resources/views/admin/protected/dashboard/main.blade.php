@extends('common.protected.dashboard.main')

@section('customCss')
	<link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet">
@endsection

@section('_nav_left')
	@include('admin.protected.dashboard.partials._nav_left')
@endsection

@section('_nav_top')
	@include('admin.protected.dashboard.partials._nav_top')
@endsection