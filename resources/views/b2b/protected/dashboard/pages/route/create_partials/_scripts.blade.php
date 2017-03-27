<script type="text/javascript">
  $('#search_form').parsley();
</script>

{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_1",
			format : "DD/MM/YYYY",

		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});
	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- requirement --}}
<script>
	$(document).on('click', '#cancel_req', function() {
		var text = $('#text_req').val();
		var showText = $('#show_req').text();
		if (text.length < 20) {
			myAlert('Please enter requirements at least 20 words');
		}else if (showText.length < 20) {
			myAlert('I think you forgot to save because you have written something but not saved it yet.');
		}
		else{
			$('#container_req').addClass('hide');
		}
	});

	$(document).on('click', '#save_req', function() {
		var text = $('#text_req').val();
		if (text.length < 20) {
			myAlert('Please enter requirements at least 20 words');
		}else{
			$('#show_req').text(text);
			$('#container_req').addClass('hide');
			var date = $('#startDate').val();
			if (date.length < 5) {
				$('#startDate').click();
			}
		}
	});

	$(document).on('click', '#edit_req', function() {
		$('#container_req').removeClass('hide');
	});
</script>
{{-- requirement --}}

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
		var totalNights = 12;
		var selectednights = 1;
		var nights = (totalNights-selectednights);
		// console.log('nights = '+nights);
		if(selectednights == 0 || nights == 0) {
			myAlert('Please check nights first');
		}
		else{
			var totalDestination = $('.destinationClass').children().length;
			var destinationListHtml = $('#destinationListHtml').html();
			var data_destination_count = (totalDestination+1);
			var destinationId = 'destination'+data_destination_count;
			var inputDestinationId = 'inputDestination'+data_destination_count;

			destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
			destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
			destinationListHtml = destinationListHtml.replace('destinationList_temp', 'destinationList');
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
	$(document).on('keyup keypress keydown paste', '.location', function(e) {
		var parent = $(this).closest('.destinationList');
		var mode = $(parent).find('.mode').val();
		var name = $(this).attr('name');

		if (mode != '') {
			
			var	url = '';

			if (mode == 'flight') {
				url = '{{ url("dashboard/tools/airport") }}?tags=flight';
			}
			else if(mode == 'cruise'){
				url = '{{ url("dashboard/tools/destination") }}?tags=cruise';
			}else{
				url = '{{ url("dashboard/tools/destination") }}';
			}

			$(parent).find('.mode').removeClass('border-red');
			$(this).autocomplete({ source: url });
			
		}else{
			$(parent).find('.mode').addClass('border-red');
		}
	});
</script>
{{-- /autocomplete --}}

{{-- changing mode --}}
<script>
	$(document).on('change', '.mode', function(){
		var thisVal = $(this).val();
		var parentId = $(this).parents().eq(1).attr('id');
		
		$('#'+parentId).find('.location-input-div').html('');

		if (thisVal == 'flight') {
			var originHtml = $('#originFlightTemp').html();
			var destinationTemp = $('#destinationTemp').html();

			$('#'+parentId).find('.location-input-div').append(originHtml);
			$('#'+parentId).find('.location-input-div').append(destinationTemp);
		}
		else if (thisVal == 'hotel' || thisVal == 'cruise') {
			var destinationTemp = $('#destinationTemp').html();
			var nightTemp = $('#nightTemp').html();

			$('#'+parentId).find('.location-input-div').append(destinationTemp);
			$('#'+parentId).find('.location-input-div').append(nightTemp);
		}
		else if (thisVal == 'ferry' || thisVal == 'train') {
			var destinationTemp = $('#destinationWithDatetimeTemp').html();
			var appendHtml = destinationTemp.replace(/temp-class/g, 'origin').replace(/"Location"/g, '"Origin"');
			appendHtml += destinationTemp.replace(/temp-class/g, 'destination').replace(/"Location"/g, '"Destination"');;
			$('#'+parentId).find('.location-input-div').append(appendHtml);
			$('#'+parentId).find('.datetimepicker').wickedpicker({now: "12:30"});
			/*$('#'+parentId).find('.datetimepicker').timepicker();*/

			/*$('#'+parentId).find('.datetimepicker').datetimepicker({
				formatDate:'d/m/Y',
				formatTime:'H:i',
				minDate: 0,
			});*/
		}

		// $('#'+parentId).find('.location').val('');
	});
</script>
{{-- /changing mode --}}

<script>
	function initDateTime(elem) {
		$(elem).datetimepicker({
			formatDate:'d/m/Y',
			formatTime:'H:i',
			minDate: 0,
		});
	}
</script>


{{-- form submition --}}

<script>
	$(document).on('click','#formSubmit', function(){
		var startDate = $('#startDate').val();

		if(startDate != ''){
			$('#startDate').addClass('border-blue-2px');
			$('#startDate').removeClass('border-red');

			var roomGuests = $('.roomGuest:visible').map(function() {
				
				var childAge = $(this).find('.age-elem').map(function() {
					return $(this).val();
				}).get();

				return {
					'NoOfAdults': $(this).find('.noOfAdult').val(),
					'ChildAge': JSON.stringify(childAge),
				}

			}).get();

			var route = getRoute();
			console.log(route);
			if (route && route.length > 0) {
				$(this).addClass('disabled');
				$(this).prop('disabled', true);
				var req = $('#show_req').text();
				var data = {
					"_token" : csrf_token,
					"startDate" : startDate,
					"req" : req,
					"route" : route,
					"roomGuests" : roomGuests
				}

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
						if(xhr.status == 401){
							window.open("{{ url('login') }}", '_blank');
						}
	        },

				});
			}
		}
		else{
			$('#startDate').addClass('border-red');
			$('#startDate').removeClass('border-blue-2px');
			myAlert('Please select start date...');
		}

	});
</script>
{{-- /form submition --}}

{{-- route function --}}
<script>
	function getRoute() {
		var route = []; 
		var routeCount = $('.destinationList').length;

		$('.destinationList').each(function(){
			var mode = $(this).find('.mode').val();
			if (mode == '') {
				$(this).find('.mode').addClass('border-red');
				myAlert('I think you forgot to select mode. it\'s vary easy just click on mode and select.');
				return false;
			}else{
				$(this).find('.mode').removeClass('border-red');
			}

			var origin = $(this).find('.origin').val();
			if (origin == '' && mode == 'flight') {
				$(this).find('.origin').addClass('border-red');
				myAlert('You forgot to write origin.');
				return false;
			}
			if((mode == 'flight' || mode == 'train' || mode == 'ferry') && origin.indexOf(', ') == -1){
				$(this).find('.origin').addClass('border-red');
				myAlert('You forgot to write origin.');
				return false;
			}
			else{
				$(this).find('.origin').removeClass('border-red');
			}

			var destination = $(this).find('.destination').val();
			if (destination == '') {
				$(this).find('.destination').addClass('border-red');
				myAlert('You forgot to write destination.');
				return false;
			}if(destination.indexOf(', ')  == -1){
				$(this).find('.destination').addClass('border-red');
				myAlert('You forgot to write destination.');
				return false;
			}else{
				$(this).find('.destination').removeClass('border-red');
			}

			var nights = $(this).find('.nights').val();
			if (nights == '') {
				$(this).find('.nights').addClass('border-red');
				myAlert('You forgot to select nights.');
				return false;
			}else{
				$(this).find('.nights').removeClass('border-red');
			}

			var origin_time = $(this).find('.origin-time').val();
			var destination_time = $(this).find('.destination-time').val();

			var routeData = {
				"mode" : mode,
				"origin" : origin,
				"origin_time" : origin_time,
				"destination" : destination,
				"destination_time" : destination_time,
				"nights" : nights,
			};

			route.push(routeData);
		});
		if (route.length == routeCount) {
			return route;
		}else{
			return false;
		}
	
	}
</script>
{{-- /route function --}}



{{-- Adults-Child-button --}}
<script>
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
					myAlert('Sorry, the minimum value was reached');
					$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
					myAlert('Sorry, the maximum value was reached');
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
