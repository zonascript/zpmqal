<script>
	{{-- bootstrap-daterangepicker --}}

	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_1",
			format : "DD/MM/YYYY",
			minDate : new Date(),
			startDate: new Date(),
		}, function(start, end, label) {
			// console.log(start.toISOString(), end.toISOString(), label);
		});

		$('.datetimepicker').each(function () {
			var time = $(this).val();
			initTimePicker(this, {now: time});
		});

	});

	{{-- /bootstrap-daterangepicker --}}


	{{-- Adding or Removing-room --}}

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

	{{-- /Adding or Removing-room --}}


	{{-- remove destination button --}}

	$('#btn-removeDestination').click(function(){
		var totalDestination = $('.destinationClass').children().length;
		$('#destination'+totalDestination).remove();

		if(totalDestination == 2){
			$('#btn-removeDestination, #pipeSaprDestination').hide();
		}
	});

	{{-- /remove destination button --}}



	{{-- requirement --}}

	$(document).on('click', '#cancel_req', function() {
		var text = $('#text_req').val();
		var showText = $('#show_req').text();
		/*if (text.length < 10) {
			$.alert('Please enter requirements at least 1 words');
		}else if (showText.length < 20) {
			$.alert('I think you forgot to save because you have written something but not saved it yet.');
		}
		else{
			$('#container_req').addClass('hide');
		}*/
		
		$('#container_req').addClass('hide');
		$('#startDate').click();

	});

	$(document).on('click', '#save_req', function() {
		var text = $('#text_req').val();
		/*if (text.length < 20) {
			$.alert('Please enter requirements at least 20 words');
		}
		else{*/
			$('#show_req').text(text);
			$('#container_req').addClass('hide');
			var date = $('#startDate').val();
			if (date.length < 5) {
				$('#startDate').click();
		/*}*/
		}
	});

	$(document).on('click', '#edit_req', function() {
		$('#container_req').removeClass('hide');
	});

	{{-- requirement --}}




	$(document).on('click', '.rmv-destlist', function () {
		var parant = $(this).closest('.destinationList');
		var rid = $(parant).attr('data-rid');

		if (rid != '') {
			postRemoveRoute(rid);
		}
		
		$(parant).remove();
	});



	{{-- Adding or Removing-Destination --}}

	$('#btn-addDestination').click(function(){
		if (postRoute()) {
			/*var totalDestination = $('.destinationClass').children().length;*/
			var destinationListHtml = $('#destinationListHtml').html();
			var data_destination_count = addDestCount();
			var destinationId = 'destination'+data_destination_count;
			var inputDestinationId = 'inputDestination'+data_destination_count;

			destinationListHtml = destinationListHtml.replace('data_destination_count', data_destination_count);
			destinationListHtml = destinationListHtml.replace('selectNight_temp', 'selectNight');
			destinationListHtml = destinationListHtml.replace('destinationList_temp', 'destinationList');
			destinationListHtml = destinationListHtml.replace('destination_count', destinationId);
			destinationListHtml = destinationListHtml.replace('inputDestination_count', inputDestinationId);
			
			$('.destinationClass').append(destinationListHtml);
			
			/*if(totalDestination == 1){
				$('#btn-removeDestination, #pipeSaprDestination').show();
			}*/
		}
	});


	{{-- /Adding or Removing-Destination --}}


	$(document).on('change', '.nights', function () {
		var nights = $(this).val();

		if (nights == '') {
			$(this).addClass('inctv border-red');
			var parent = $(this).closest('.destinationList');
			changeInRoute(parent);
		}
		else{
			$(this).removeClass('inctv');
			$(this).removeClass('border-red');
		}
	});


	{{-- changing mode --}}

	$(document).on('change', '.mode', function(){
		if(checkStartDate()){
			var thisVal = $(this).val();
			var parent = $(this).closest('.destinationList');
			changeInRoute(parent);

			$(parent).find('.location-input-div').html('');
			
			if (thisVal == '') {
				$(this).addClass('inctv border-red');
			}
			else{
				$(this).removeClass('inctv');
				$(this).removeClass('border-red');
			}

			if (thisVal == 'flight') {
				var originHtml = $('#originFlightTemp').html();
				var destinationTemp = $('#destinationTemp').html();

				$(parent).find('.location-input-div').append(originHtml);
				$(parent).find('.location-input-div').append(destinationTemp);
			}
			else if (thisVal == 'hotel' || thisVal == 'cruise') {
				var destinationTemp = $('#destinationTemp').html();
				var nightTemp = $('#nightTemp').html();

				$(parent).find('.location-input-div').append(destinationTemp);
				$(parent).find('.location-input-div').append(nightTemp);
			}
			else if (thisVal == 'ferry' || thisVal == 'train' || thisVal == 'bus') {
				var destinationTemp = $('#destinationWithDatetimeTemp').html();
				var appendHtml = destinationTemp.replace(/temp-class/g, 'origin').replace(/"Location"/g, '"Origin"');
				appendHtml += destinationTemp.replace(/temp-class/g, 'destination').replace(/"Location"/g, '"Destination"');;
				$(parent).find('.location-input-div').append(appendHtml);
				initTimePicker($(parent).find('.datetimepicker'), {now: "12:30"});
			}
			// $(parent).find('.location').val('');
		}
	});

	{{-- /changing mode --}}


	$(document).on('keypress', '.datetimepicker', function(event) {
		event.preventDefault();
	});


	{{-- form submition --}}

	$(document).on('click','#formSubmit', function(){
		formSubmit(this);
	});

	{{-- /form submition --}}


	{{-- Adults-Child-button --}}

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
					$.alert('Sorry, the minimum value was reached');
					$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
					$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
					$.alert('Sorry, the maximum value was reached');
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

	{{-- /Adults-Child-button --}}
</script>

@include($viewPath.'.create_partials.autocomplete')
@include($viewPath.'.create_partials.function')