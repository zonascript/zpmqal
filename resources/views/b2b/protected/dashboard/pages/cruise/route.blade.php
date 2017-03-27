@extends('b2b.protected.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
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
						<img class="width-100-p" src="{{ asset('images/user.jpg') }}" alt="Profile Image" />
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
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-1 col-sm-offset-1">
				<div class="row">	
					<div class="x_panel">
						<form id="search_form" data-parsley-validate>
							<div class="x_title" >
								<div class="row">
									<div class="col-md-8 col-sm-8 col-xs-12">
										<h3><i class="fa fa-road"></i> Define Your Route</h3>
									</div>

									<div class="col-md-4 col-sm-4 col-xs-12 m-top-5">
										<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival" placeholder="Start Date" id="startDate" aria-describedby="inputSuccess2Status3">
										<i class="fa fa-calendar form-control-feedback right" aria-hidden="true"></i>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
																		</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="x_content nopadding">
								<div class="form-group">
									<div id="" class="destinationClass">
										<div id="destination1" data-destination="1" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList">
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select class="form-control nopadding p-left-10 selectNight mode" required="" data-parsley-type="integer" data-parsley-gt="0">
													<option value="" selected>Select Mode</option>
													<option value="flight">Flight</option>
													<option value="train">Train</option>
													<option value="Road">Road</option>
													
												</select>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input id="inputDestination1" type="text" class="form-control has-feedback location origin" placeholder="Origin" required="">
												<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input id="inputDestination1" type="text" class="form-control has-feedback location destination" placeholder="Destination" required="">
												<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<select class="form-control nopadding p-left-10 nights " required="" data-parsley-type="integer" data-parsley-gt="0">
													<option value="" selected>Select Night</option>
													@for ($i = 1; $i <= 12 ; $i++)
														<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
													@endfor
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 m-top-10">
											<a id="btn-addDestination" class="btn-link cursor-pointer">Add Route</a>
											<span id="pipeSaprDestination" hidden> | </span>
											<a id="btn-removeDestination" class="btn-link cursor-pointer" hidden>Remove Route</a>
									</div>

								</div>
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
	<div hidden>

		{{-- Destination Html --}}

		<div id="destinationListHtml">
			<div id="destination_count" data-destination="data_destination_count" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList">
				<div class="col-md-2 col-sm-2 col-xs-12">
					<select class="form-control nopadding p-left-10 mode" required="" data-parsley-type="integer" data-parsley-gt="0">
						<option value="" selected>Select Mode</option>
						<option value="flight">Flight</option>
						<option value="train">Train</option>
						<option value="Road">Road</option>
						
					</select>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<input type="text" class="form-control has-feedback origin location" placeholder="Origin" required="">
					<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<input type="text" class="form-control has-feedback destination location" placeholder="Destination" required="">
					<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-12">
					<select class="form-control nopadding p-left-10 nights" required="" data-parsley-type="integer" data-parsley-gt="0">
						<option value="" selected>Select Night</option>
						@for ($i = 1; $i <= 12 ; $i++)
							<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
						@endfor
					</select>
				</div>
			</div>
		</div>
		{{-- Destination Html --}}

	</div>
	{{-- /Hidden template Html  --}}

@endsection



@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>

	<script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script>
	<script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script>
	{{-- /bootstrap-daterangepicker --}}

	<script src="{{ asset('js/parsley.min.js') }}"></script>

@endsection

@section('scripts')

	{{-- bootstrap-daterangepicker --}}
	<script>
		$(document).ready(function() {
			$('.datepicker').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_1",
				format : "D/M/YYYY",

			}, function(start, end, label) {
				console.log(start.toISOString(), end.toISOString(), label);
			});

		});
	</script>
	{{-- /bootstrap-daterangepicker --}}

	<script type="text/javascript">
	  $('#search_form').parsley();
	</script>
	
	{{-- Adding or Removing-Destination --}}
	<script>
		$('#btn-addDestination').click(function(){
			var totalNights = 12;
			var selectednights = 1;
			var nights = (totalNights-selectednights);
			console.log('nights = '+nights);
			if(selectednights == 0 || nights == 0) {
				alert('Please check nights first');
			}
			else{
				var totalDestination = $('.destinationClass').children().length;
				var destinationListHtml = $('#destinationListHtml').html();
				var data_destination_count = (totalDestination+1);
				var destinationId = 'destination'+data_destination_count;
				var inputDestinationId = 'inputDestination'+data_destination_count;

				destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
				destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
				destinationListHtml = destinationListHtml.replace('destination_count', destinationId);
				destinationListHtml = destinationListHtml.replace('inputDestination_count', inputDestinationId);
				
				$('.destinationClass').append(destinationListHtml);
				
				if(totalDestination == 1){
					$('#btn-removeDestination, #pipeSaprDestination').show();
				}
			}
		});

		$('#btn-removeDestination').click(function(){
			var totalDestination = $('.destinationClass').children().length;
			$('#destination'+totalDestination).remove();

			if(totalDestination == 2){
				$('#btn-removeDestination, #pipeSaprDestination').hide();
			}
		});
	</script>
	{{-- /Adding or Removing-Destination --}}
	
	{{-- autocomplete --}}
	<script>
		$(document).on('click', '.location', function(e) {
			$(this).autocomplete({
				source: '{{ url("dashboard/tools/destination") }}'
			});
		});
	</script>
	{{-- /autocomplete --}}
	

	{{-- Rating --}}
	<script>
		$('.btn-starRating').click(function(e){
			var dataRating = $('.btn-starRating .font-gold').attr('data-rating');
			var thisDataRating = $(this).find('.span-starRatting').attr('data-rating');
			var dataRating_length = $('.btn-starRating .font-gold').length;

			// alert(dataRating+' '+thisDataRating+' '+dataRating_length);

			if(dataRating_length == 1){
				$(this).find('.span-starRatting').toggleAttr('data-status', 'true', 'false');
				$(this).find('.span-starRatting').toggleClass('font-gold');
			}
			else if(dataRating != undefined){

				if(dataRating <= thisDataRating){
					for (var i = parseInt(dataRating)+1; i <= thisDataRating; i++) {
						$('[data-rating = "'+i+'" ]').attr('data-status', 'true');
						$('[data-rating = "'+i+'" ]').addClass('font-gold');
					}
					for (var removeI = parseInt(thisDataRating)+1; removeI <= 5; removeI++) {
						$('[data-rating = "'+removeI+'" ]').removeClass('font-gold');
						$('[data-rating = "'+removeI+'" ]').attr('data-status', 'false');
					}
				}
				else if(dataRating >= thisDataRating){
					for (var i = thisDataRating; i < dataRating; i++) {
						$('[data-rating = "'+i+'" ]').toggleAttr('data-status', 'true', 'false');
						$('[data-rating = "'+i+'" ]').toggleClass('font-gold');
					}
				}
			}
			else{
				$(this).find('.span-starRatting').toggleAttr('data-status', 'true', 'false');
				$(this).find('.span-starRatting').toggleClass('font-gold');
			}

			
		})
	</script>
	{{-- /Rating --}}

	{{-- form submition --}}
	<script>
		$(document).on('click','#formSubmit', function(){
			var startDate = $('#startDate').val();

			if(startDate != ''){
				var route = getRoute();
				if (route) {

					var data = {
						"_token" : "{{ csrf_token() }}",
						"startDate" : startDate,
						"route" : route,
					}

					console.log(JSON.stringify(data));


					$.ajax({
						type:"post",
						url: "{{ Request::url() }}", 
						data: data,
						success: function(responce, textStatus, xhr) {
							if(xhr.status == 200){
								responce_obj = JSON.parse(responce);
								console.log(responce_obj.nextUrl);
								document.location.href = responce_obj.nextUrl;
							}
		        },

		        error: function(xhr, textStatus) {
							// console.log(textStatus);
							// console.log(xhr.status);
							if(xhr.status == 401){
								window.open("{{ url('login') }}", '_blank');
							}
		        },

					});
				}
			}
			else{
				alert('Please Select Start Date First.');
			}

		});
	</script>
	{{-- /form submition --}}

	{{-- route function --}}
	<script>
		function getRoute() {
			var route = []; 

			var routeCount = $('.destinationList').length;
			console.log(routeCount);

			$('.destinationList').each(function(){
				var mode = $(this).find('.mode').val();
				if (mode == '') {
					$(this).find('.mode').addClass('border-red');
					return false;
				}else{
					$(this).find('.mode').removeClass('border-red');
				}

				var origin = $(this).find('.origin').val();
				if (origin == '') {
					$(this).find('.origin').addClass('border-red');
					return false;
				}else{
					$(this).find('.origin').removeClass('border-red');
				}

				var destination = $(this).find('.destination').val();
				if (destination == '') {
					$(this).find('.destination').addClass('border-red');
					return false;
				}else{
					$(this).find('.destination').removeClass('border-red');
				}

				var nights = $(this).find('.nights').val();
				if (nights == '') {
					$(this).find('.nights').addClass('border-red');
					return false;
				}else{
					$(this).find('.nights').removeClass('border-red');
				}

				var routeData = {
					"mode" : mode,
					"origin" : origin,
					"destination" : destination,
					"nights" : nights,
				};

				route.push(routeData);
			});
			
			if (route.length == routeCount-1) {
				return route;
			}else{
				return false;
			}
		
		}
	</script>
	{{-- /route function --}}

@endsection