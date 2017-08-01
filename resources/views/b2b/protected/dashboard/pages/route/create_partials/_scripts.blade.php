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
		storeRoom();
		addRoom();
	});

	$(document).on('click', '.rmv-room', function(){
		removeRoom(this);
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
		if(postRoute()){
			bootSubmitEvent(this);
			storeRoom();
			setTimeout(function () {
				formSubmit(this);
			}, 2000);
		}
	});

	{{-- /form submition --}}


	$(document).on('click', '.btn-child', function () {
		var id = $(this).attr('field');
		var val = $(id).val();
		childAgeElem(this, val, 2);
	});

	$(document).on('click change', '.btn-number, .age-elem', function () {
		addInactiveClass(this);
	});

</script>

@include($viewPath.'.create_partials.autocomplete')
@include($viewPath.'.create_partials.function')