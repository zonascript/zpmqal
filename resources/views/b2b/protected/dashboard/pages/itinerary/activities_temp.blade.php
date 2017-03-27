@extends('admin.dashboard.main')

@section('title', ' | Package Builder')
{{-- @section('jquery', 'section over changed') --}}

@section('css')
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> --}}
  <link rel="stylesheet" href="{{ asset('admin/css/themes/smoothness/jquery-ui.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('test/datepicker/bootstrap-datepicker.css') }}">
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
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
						<h2><b>Auckland</b> (Activities)</h2>
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12">
						<h2 class="pull-right">( 03-Nov-2016 To 09-Nov-2016 )</h2>
					</div>
					<div class="col-md-1 col-sm-1 col-xs-12 nopadding">
						<ul class="nav navbar-right panel_toolbox panel_toolbox1">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
						
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
					<select class="form-control nopadding p-left-10 selectNight_temp"  required="" data-parsley-type="integer" data-parsley-gt="0">
						Replace_NightsOption
						{{-- <option value="" selected>Select Night</option>
						@for ($i = 1; $i <= $packageInfo->nights; $i++)
							<option value="{{ $i }}">{{ $i == 1 ? $i.' Night' : $i.' Nights' }}</option>
						@endfor --}}
					</select>
				</div>
			</div>
		</div>
		{{-- Destination Html --}}

	</div>
	{{-- /Hidden template Html  --}}

@endsection


@section('jquery')
	<script type="text/javascript" src="{{ asset('test/datepicker/jquery.min.js') }}"></script>
@endsection

@section('js')
	{{-- bootstrap-daterangepicker --}}
	<script type="text/javascript" src="{{ asset('admin/js/jquery-ui-2.js') }}"></script>
	<script type="text/javascript" src="{{ asset('admin/js/bootstrap-datepicker.js') }}"></script>

	{{-- <script src="{{ asset('admin/dashboard/js/moment/moment.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('admin/dashboard/js/datepicker/daterangepicker.js') }}"></script> --}}
	{{-- /bootstrap-daterangepicker --}}

	<script type="text/javascript" src="{{ asset('js/parsley.min.js') }}"></script>

@endsection

@section('scripts')

	<script type="text/javascript">
	  $('#search_form').parsley();
	</script>
	
	{{-- bootstrap-daterangepicker --}}

	{{-- <script type="text/javascript">
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
	</script> --}}

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
			var totalNights = {{ $packageInfo->nights }};
			var selectednights = getNights();
			var nights = (totalNights-selectednights);
			console.log('nights = '+nights);
			if(selectednights == 0 || nights == 0) {
				alert('Please check nights first');
			}
			else{
				var nightsOption = getNightsOption(nights);
				var totalDestination = $('.destinationClass').children().length;
				var destinationListHtml = $('#destinationListHtml').html();
				var data_destination_count = (totalDestination+1);
				var destinationId = 'destination'+data_destination_count;
				var inputDestinationId = 'inputDestination'+data_destination_count;

				destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
				destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
				destinationListHtml = destinationListHtml.replace('Replace_NightsOption', nightsOption);
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
			var selectedNights = getNights();
			var totalNights = {{ $packageInfo->nights }};

			if(selectedNights == totalNights){


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
					"_token" : "{{ csrf_token() }}",
					"Destinations" : destinations,
					"RoomGuests" :roomguests,
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
			else{
				alert('All no. of nights should be occupied');
			}

		});
	</script>
	{{-- /form submition --}}


	{{-- Changing Nights --}}
	<script>
		$(document).on('change', '.selectNight', function(){
			var currentIndex = $(this).index('.selectNight');
			// alert($('.selectNight:gt(index)'));
			console.log(currentIndex);
			// alert('this working');
		});
	</script>
	{{-- /Changing Nights --}}

	{{-- Getting No of Selected Night --}}
	<script>
		function getNights(){
			var nights = 0;			
			$('.selectNight').each(function(){
				nights += $(this).val() != '' ? parseInt($(this).val()) : 0;
			});
			return nights;
		}
	</script>
	{{-- /Getting No of Selected Night --}}

	{{-- Get Nights Option --}}
	<script>
		function getNightsOption(nights){
			var nightsOption = '';
			for (var i = 1; i <= nights; i++) {
				var nightWord = i == 1 ? ' Night' : ' Nights';
				if (i != nights) {
					nightsOption +=	'<option value="'+i+'">'+i+nightWord+'</option>';
				}
				else{
					nightsOption +=	'<option value="'+i+'" selected>'+i+nightWord+'</option>';
				}
			}

			console.log(nightsOption);

			return nightsOption;
		}
	</script>
	{{-- /Get Nights Option --}}
@endsection