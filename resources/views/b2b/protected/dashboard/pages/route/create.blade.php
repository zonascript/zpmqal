@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ commonAsset('timepicker/wickedpicker.min.css') }}"/>
	<link rel="stylesheet" href="{{ commonAsset('timepicker/jquery.timepicker.css') }}"/>
	{{-- <link rel="stylesheet" href="{{ commonAsset('datetimepicker/jquery.datetimepicker.min.css') }}"/> --}}
@endsection

@section('menutab')
	@include('b2b.protected.dashboard.pages.route.create_partials._menu')
@endsection

@section('content')
	@include('b2b.protected.dashboard.pages.route.create_partials.req')
	<div class="row">
		{{-- Hotel Serach --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
				<div class="row">	
					<div class="x_panel">
						<form id="search_form" data-parsley-validate>
							<div class="x_title" >
								<div class="row">
									<div class="col-md-8 col-sm-8 col-xs-12">
										<h3>
											<i class="fa fa-road"></i>
											Define Your Route
											<small>(Package Id : {{ $package->uid }})</small>
										</h3>
									</div>

									<div class="col-md-4 col-sm-4 col-xs-12 m-top-5">
										<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival border-blue-2px" placeholder="Start Date" id="startDate" aria-describedby="inputSuccess2Status3" data-pid="{{$package->id}}">
										<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
									</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label for="">Requirements:</label>
										<span id="show_req"></span>
										<a id="edit_req" class="btn btn-link">Edit</a>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="x_content nopadding">
								<div class="form-group">
									<div class="destinationClass">
										<div id="destination1" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList no-rid" data-destination="1" data-rid="">
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select class="form-control nopadding p-left-10 mode inctv" required="" data-parsley-type="value">
													<option value="" selected="">Select Mode</option>
													<option value="flight">Flight</option>
													<option value="train">Train</option>
													<option value="hotel">Land</option>
													<option value="ferry">Ferry</option>
													<option value="cruise">Cruise</option>
												</select>
											</div>
											<div class="col-md-9 col-sm-9 col-xs-12">
												<div class="row location-input-div"></div>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12 text-center">
												<a class="rmv-destlist cursor-pointer">
													<i class="fa fa-times-circle font-size-30 m-top-2"></i>
												</a>
											</div>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
											<a id="btn-addDestination" class="btn-link cursor-pointer" data-count="1">Add Route</a>
											<span id="pipeSaprDestination" hidden> | </span>
											<a id="btn-removeDestination" class="btn-link cursor-pointer" hidden>Remove Route</a>
									</div>

								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">
									<hr>
									<h2>Guests Detail</h2>
								</div>

								{{-- Rooms-element  --}}
								<div id="room">
									@for ($room = 1; $room <= 8 ; $room++)
										{{-- expr --}}
									<div id="room_{{ ($room+1)/2 }}" {{ $room != 1 ? 'hidden' : '' }} class="roomGuest">
										<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
											<label for="">Room : {{ ($room+1)/2 }}</label>
										</div>

										{{-- Adult Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
											<div class="center">
												<div class="input-group">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_{{ $room }}" data-name="adult">
															<span class="glyphicon glyphicon-minus"></span>
														</button>
													</span>
													<span class="form-control text-center nopadding-right">
														<span id="a_value">
															<input type="text" name="quant_{{ $room }}" class="width-10 nostyle input-number noOfAdult" value="2" min="1" max="4" disabled="disabled" required="" data-parsley-type="integer" data-parsley-gt="0">
														</span>
														<span id="a_word" name="quant_{{ $room }}">Adult</span>
													</span>
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_{{ $room }}" data-name="adult">
															<span class="glyphicon glyphicon-plus"></span>
														</button>
													</span>
												</div>
											</div>
										</div>
										{{-- /Adult Button --}}

										<?php $room++ ?>
										{{-- Child Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback">
											<div class="center">
												<div class="input-group">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_{{ $room }}" data-name="child">
															<span class="glyphicon glyphicon-minus"></span>
														</button>
													</span>
													<span class="form-control text-center nopadding-right">
														<span id="a_value">
															<input type="text" name="quant_{{ $room }}" class="width-10 nostyle input-number noOfChild" value="0" min="0" max="2" disabled="disabled">
														</span>
														<span id="c_word" name="quant_{{ $room }}">Child</span>
													</span>
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_{{ $room }}" data-name="child">
															<span class="glyphicon glyphicon-plus"></span>
														</button>
													</span>
												</div>
											</div>
										</div>
										{{-- /Child Button --}}

										{{-- Age html --}}
										<div class="col-md-4 col-sm-4 col-xs-12 p-bottom-1 m-bottom-n-5 form-group has-feedback age" data-age="quant_{{ $room }}"></div>
										{{-- /age html --}}

									</div>
									
									@endfor
								</div>
								{{-- /Rooms-element  --}}
								{{-- Add Room button --}}
								<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1">
									<div >
										<a id="btn-addRoom" class="btn-link cursor-pointer">Add Room</a>
										<span id="pipeSapr" hidden> | </span>
										<a id="btn-removeRoom" class="btn-link cursor-pointer" hidden>Remove Room</a>
									</div>
								</div>
								{{-- /Add Room button --}}


								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-top-30">
									<button type="button" id="formSubmit" class="btn btn-success btn-block">Next</button>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
		{{-- /Hotel Serach --}}
	</div>
	
	{{-- Hidden template Html  --}}
	@include('b2b.protected.dashboard.pages.route.create_partials._hidden')
	{{-- /Hidden template Html  --}}

@endsection


@section('js')
	{{-- autocomplete --}}
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script type="text/javascript" src="{{commonAsset('timepicker/wickedpicker.min.js')}}"></script>
	<script type="text/javascript" src="{{commonAsset('timepicker/jquery.timepicker.min.js')}}"></script>

	{{-- <script src="{{ commonAsset('datetimepicker/jquery.datetimepicker.full.js') }}"></script> --}}
	{{-- autocomplete --}}
	
	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	<script src="{{ asset('js/parsley.min.js') }}"></script>

@endsection

@section('scripts')
	@include('b2b.protected.dashboard.pages.route.create_partials._scripts')
@endsection
