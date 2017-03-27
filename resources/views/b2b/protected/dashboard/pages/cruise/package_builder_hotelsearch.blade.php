@extends('admin.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> --}}
  <link rel="stylesheet" href="{{ commonAsset('css/themes/smoothness/jquery-ui.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ commonAsset('datepicker/bootstrap-datepicker.css') }}">
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
								<h2><div class="text-center"><i class="fa fa-building"></i> Hotel Search</div></h2>
								<div class="clearfix"></div>
							</div>
							<div class="x_content nopadding">
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>Select your dates</h2>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12 form-group-self">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<span class="form-control-feedback width-30-p m-top-5 left" aria-hidden="true">Arrival Date</span>
											<input type="text" class="span2 dpd1a form-control has-feedback p-left-40-p" id="arrivalDate" data-date-format="dd/mm/yyyy"  name="checkOut" required="">
											<i class="fa fa-calendar form-control-feedback m-top-5 right" aria-hidden="true"></i>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<span class="form-control-feedback width-30-p m-top-5 left" aria-hidden="true">Departure Date</span>
											<input type="text" class="span2 dpd2a form-control has-feedback p-left-40-p" id="departureDate" data-date-format="dd/mm/yyyy"  name="checkOut" required="">
											<i class="fa fa-calendar form-control-feedback m-top-5 right" aria-hidden="true"></i>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<hr>
										<h2>Select your destinations</h2>
									</div>
									<div class="destinationClass">
										<div id="destination1" data-destination="1" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList">
											<div class="col-md-9 col-sm-9 col-xs-12">
												<span class="form-control-feedback left width-25-p m-top-5" aria-hidden="true">Destination</span>
												<input id="inputDestination1" type="text" class="form-control has-feedback p-left-30-p inputDestination" placeholder="Select City, Area..." required="">
												<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-12">
												<select class="form-control nopadding age-elem p-left-10 selectNight" required="" data-parsley-type="integer" data-parsley-gt="0">
													<option value="" selected>Select Night</option>
													@for ($i = 1; $i <= 12; $i++)
														<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
													@endfor
												</select>
											</div>
										</div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
											<a id="btn-addDestination" class="btn-link cursor-pointer">Add Destination</a>
											<span id="pipeSaprDestination" hidden> | </span>
											<a id="btn-removeDestination" class="btn-link cursor-pointer" hidden>Remove Destination</a>
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

									{{-- Star Rating button --}}
									<div class="col-md-12 col-sm-12 col-xs-12 p-bottom-1 m-top-20">
										
											<button type="button" id="formSubmit" class="btn btn-success btn-block">Submit</button>

									</div>
									{{-- /Star Rating button --}}

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
		{{-- age html --}}
			<div id="age_temp">
				<div class="col-md-6 col-sm-6 col-xs-12 p-bottom-1 form-group has-feedback nopadding">
					<select class="form-control nopadding age-elem" required="" data-parsley-type="integer" data-parsley-gt="0">
						<option selected>Age</option>
						@for ($i = 1; $i <= 12; $i++)
							<option>{{ $i }}</option>
						@endfor
					</select>
				</div>
			</div>
		{{-- /age html --}}

		{{-- Destination Html --}}
		<div id="destinationListHtml">
			<div id="destination_count" data-destination="data_destination_count" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<span class="form-control-feedback left width-25-p m-top-5" aria-hidden="true">Destination</span>
					<input id="inputDestination_count" type="text" class="form-control has-feedback p-left-30-p inputDestination" placeholder="Select City, Area..." required="">
					<i class="fa fa-map-marker form-control-feedback right m-top-5" aria-hidden="true"></i>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<select class="form-control nopadding age-elem p-left-10 selectNight"  required="" data-parsley-type="integer" data-parsley-gt="0">
						<option value="" selected>Select Night</option>
						@for ($i = 1; $i <= 12; $i++)
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


@section('jquery')
	<script type="text/javascript" src="{{ commonAsset('datepicker/jquery.min.js') }}"></script>
@endsection

@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ commonAsset('js/jquery-ui-2.js') }}"></script>
	<script type="text/javascript" src="{{ commonAsset('js/bootstrap-datepicker.js') }}"></script>

	{{-- <script src="{{ commonAsset('dashboard/js/moment/moment.min.js') }}"></script> --}}
	{{-- <script src="{{ commonAsset('dashboard/js/datepicker/daterangepicker.js') }}"></script> --}}
	{{-- /bootstrap-daterangepicker --}}

	<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>

@endsection

@section('scripts')

	<script type="text/javascript">
	  $('#search_form').parsley();
	</script>
	
	{{-- bootstrap-daterangepicker --}}

	<script type="text/javascript">
		$(document).ready(function(){
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			checkInOut($('.dpd1a'), $('.dpd2a'), now);
			checkInOut($('.dpd1b'), $('.dpd2b'), now);
		});
		
		var checkInOut = function(inEl, outEl, now) {
			var checkin = inEl.datepicker({
				singleDatePicker: true,
				calender_style: "picker_3",
				onRender: function(date) {
					return date.valueOf() < now.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev) {
				if (ev.date.valueOf() > checkout.date.valueOf()) {
					var newDate = new Date(ev.date);
					newDate.setDate(newDate.getDate() + 1);
					checkout.setValue(newDate);
				}
				checkin.hide();
				outEl.focus();
			}).data('datepicker');
			var checkout = outEl.datepicker({
				onRender: function(date) {
					return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
				}
			}).on('changeDate', function(ev) {
				checkout.hide();
			}).data('datepicker');
		};
	</script>

	{{-- <script>
		$(document).ready(function() {


			$('#checkinDate').daterangepicker({
				singleDatePicker: true,
				calender_style: "picker_3",
				format: 'DD/MM/YYYY',
				minDate: new Date()
			}, function(start, end, label) {
				console.log(start.toISOString(), end.toISOString(), label);
			});


			$('#checkoutDate').click(function(){
				var checkinDate = $('#checkinDate').val();
				if(checkinDate == ''){
					alert("Select Check In Date First");
				}
				else{
					$(this).daterangepicker({
						singleDatePicker: true,
						calender_style: "picker_3",
						format: 'DD/MM/YYYY',
						minDate: (checkinDate+1)
					}, function(start, end, label) {
						console.log(start.toISOString(), end.toISOString(), label);
					});
				}
			});
		});
	</script> --}}
	{{-- /bootstrap-daterangepicker --}}

	{{-- Adults-Child-button --}}
	<script>
		//plugin bootstrap minus and plus
		//http://jsfiddle.net/laelitenetwork/puJ6G/
		$('.btn-number').click(function(e){
				e.preventDefault();
				
				fieldName = $(this).attr('data-field');
				type      = $(this).attr('data-type');
				dataName = $(this).attr('data-name');
				var input = $("input[name='"+fieldName+"']");
				var spanWord_elem = $("span[name='"+fieldName+"']");
				var currentVal = parseInt(input.val());
				var spanWord = spanWord_elem.text(); 
				
				if (!isNaN(currentVal)) {
						if(type == 'minus') {
								
								if(currentVal > input.attr('min')) {
										input.val(currentVal - 1).change();
								} 
								if(parseInt(input.val()) == input.attr('min')) {
										$(this).attr('disabled', true);
								}

								if(currentVal == 2 && spanWord == 'Adults'){
									spanWord_elem.text('Adult');
								}

								if(dataName == 'child'){
									$("[data-age='"+fieldName+"'] div:nth-child("+currentVal+")").remove();
								}
								
								if(currentVal == 2 && spanWord == 'Children'){
									spanWord_elem.text('Child');
								}

						} else if(type == 'plus') {

								if(currentVal < input.attr('max')) {
										input.val(currentVal + 1).change();
								}
								if(parseInt(input.val()) == input.attr('max')) {
										$(this).attr('disabled', true);
								}

								if(currentVal >= 1 && spanWord == 'Adult'){
									spanWord_elem.text('Adults');
								}

								if(dataName == 'child'){
									var chhild_elem = $("#age_temp").html();
									$("[data-age='"+fieldName+"']").append(chhild_elem);
								}

								if(currentVal >= 1 && spanWord == 'Child'){
									spanWord_elem.text('Children');
								}
						}
				} else {
						input.val(0);
				}
		});

		$('.input-number').focusin(function(){
			 $(this).data('oldValue', $(this).val());
		});

		$('.input-number').change(function() {
				
				minValue =  parseInt($(this).attr('min'));
				maxValue =  parseInt($(this).attr('max'));
				valueCurrent = parseInt($(this).val());
				
				name = $(this).attr('name');
				if(valueCurrent >= minValue) {
						$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
				} else {
						alert('Sorry, the minimum value was reached');
						$(this).val($(this).data('oldValue'));
				}
				if(valueCurrent <= maxValue) {
						$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
				} else {
						alert('Sorry, the maximum value was reached');
						$(this).val($(this).data('oldValue'));
				}
				
		});

		$(".input-number").keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
						 // Allow: Ctrl+A
						(e.keyCode == 65 && e.ctrlKey === true) || 
						 // Allow: home, end, left, right
						(e.keyCode >= 35 && e.keyCode <= 39)) {
								 // let it happen, don't do anything
								 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
						e.preventDefault();
				}
		});
	</script>
	{{-- /Adults-Child-button --}}

	{{-- Adding or Removing-room --}}
	<script>
		$(document).on('click','#btn-addRoom',function(){
			var currentRoom = $('#room').children(":visible").length;
		
			$('#room_'+(currentRoom+1)).show();
			
			if(currentRoom == 1){
				$('#btn-removeRoom, #pipeSapr').show();
			}
			if(currentRoom == 3){
				$('#btn-addRoom, #pipeSapr').hide();
			}
		});

		$(document).on('click','#btn-removeRoom',function(){
			var currentRoom = $('#room').children(":visible").length;

			$('#room_'+(currentRoom)).hide();
			
			if(currentRoom == 2){
				$('#btn-removeRoom, #pipeSapr').hide();
			}
			if(currentRoom == 4){
				$('#btn-addRoom, #pipeSapr').show();
			}
		});
	</script>
	{{-- /Adding or Removing-room --}}

	
	{{-- Adding or Removing-Destination --}}
	<script>
		$('#btn-addDestination').click(function(){
			var totalDestination = $('.destinationClass').children().length;
			var destinationListHtml = $('#destinationListHtml').html();
			var data_destination_count = (totalDestination+1);
			var destinationId = 'destination'+data_destination_count;
			var inputDestinationId = 'inputDestination'+data_destination_count;

			destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
			destinationListHtml = destinationListHtml.replace('destination_count', destinationId);
			destinationListHtml = destinationListHtml.replace('inputDestination_count', inputDestinationId);
			
			$('.destinationClass').append(destinationListHtml);
			
			if(totalDestination == 1){
				$('#btn-removeDestination, #pipeSaprDestination').show();
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
		$(function() {
			$(document).on('click', '[data-destination]', function(){
				var data_destination_count = $(this).attr('data-destination');
				var inputDestination = '#inputDestination'+data_destination_count;
				$(this).find(inputDestination).autocomplete({
					source: '{{ url("dashboard/tools/destination") }}'
				});
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
			var checkinDate = $('#arrivalDate').val();
			var checkoutDate = $('#departureDate').val();

			if(checkinDate != '' || checkoutDate != ''){


				console.log(checkinDate+' '+checkoutDate);

				var destinations = $('.destinationClass .destinationList').map(function() {
					return {
						'Destination': $(this).find('.inputDestination').val(),
						'Nights': $(this).find('.selectNight').val(),
					}
				}).get();

				// console.log(JSON.stringify(destinations));

				var roomguests = $('.roomGuest:visible').map(function() {
					
					var childAge = $(this).find('.age-elem').map(function() {
						return $(this).val();
					}).get();

					// console.log(JSON.stringify(childAge));


					return {
						'NoOfAdults': $(this).find('.noOfAdult').val(),
						'ChildAge': JSON.stringify(childAge),
					}

				}).get();

				var data = {
					"ArrivalDate" : checkinDate,
					"DepartureDate" : checkoutDate,
					"Destinations" : destinations,
					"RoomGuests" :roomguests,
				}

				console.log(JSON.stringify(data));


				$.ajax({
					type:"get",
					url: "{{ url('dashboard/package/itinerary/save/'.$client->id) }}",
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
			else{
				alert('Enter Date Correctlly');
			}

		});
	</script>
	{{-- /form submition --}}

@endsection