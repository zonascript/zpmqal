
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3"
		}, function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		});

	});
</script>
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
	$('#btn-addRoom').click(function(){
		var currentRoom = $('#room').children(":visible").length;
	
		$('#room_'+(currentRoom+1)).show();
		
		if(currentRoom == 1){
			$('#btn-removeRoom, #pipeSapr').show();
		}
		if(currentRoom == 3){
			$('#btn-addRoom, #pipeSapr').hide();
		}
	});

	$('#btn-removeRoom').click(function(){
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

{{-- Rating --}}
<script>
	$('.btn-starRating').click(function(e){
		// alert($('.font-gold').attr('data-rating'));
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

{{-- filter List.js--}}
<script>
	var options = {
		valueNames: [ 'hotelName', 'hotelPrice', 'starRating' ]
	};

	var hotelResultList = new List('hotelResult', options);

	$('.filterSelect').change(function(){
		var selection = $(this).val();
		// hotelResultList.sort(selection);
		// alert(selection);
		$('#filterButton').attr('data-sort', selection);
		$('#filterButton').click();
	});
</script>
{{-- /filter List.js --}}

{{-- Choose Room --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		
		var hotelIndex = $(this).attr('data-hotelIndex');
		var vendor = $(this).attr('data-vendor');
		var uniqueKey = hotelIndex;
		if (vendor == 'tbtq') {
			uniqueKey = 't_'+hotelIndex
		}
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var currntHotelDetailId = 'hoteldetail-'+uniqueKey;

		var currntHotelRoomlId = 'roomresult-'+uniqueKey; // this is no longer used
		var currntHotelDetailBoxId = 'main_hotelDetail_'+uniqueKey;

		var isVisible = $('#'+currntHotelDetailId).is(':visible');

		if(isVisible){
			$('#'+currntHotelDetailId).hide();
		}
		else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
			
			$('#'+currntHotelDetailId).show();
			$('#'+visibleHotelDetailId).hide();
			$('#'+currntHotelDetailBoxId).empty();

			// console.log(visibleHotelDetailId+' '+currntHotelDetailId);

			var data = {
				"_token" : "{{ Session::token() }}",
				"index" :hotelIndex,
				"vendor" : vendor
			}

			// console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				url: "{{ urlHotelsRoomBuilder($urlVariable->packageHotelId) }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					// console.log(textStatus);
					if(xhr.status == 200){
						$('#'+currntHotelDetailBoxId).empty();
						$('#'+currntHotelDetailBoxId).html(responce);
						// document.location.href = this.url;
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responceHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
						$('#'+currntHotelDetailBoxId).html(responceHtml);
					}
				},
			});
		}
		else{
			// $('#'+currntHotelDetailId+', #'+visibleHotelDetailId).toggle();
			alert('Error!!!');
		}

	})
</script>
{{-- /Choose Room --}}

{{-- Choose Room --}}
<script>
	$(document).on('click','.btn-chooseRoomOld', function(){
		
		var hotelIndex = $(this).attr('data-hotelIndex');
		var vendor = $(this).attr('data-vendor');
		var uniqueKey = hotelIndex;
		if (vendor == 'tbtq') {
			uniqueKey = 't_'+hotelIndex
		}
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var currntHotelDetailId = 'hoteldetail-'+uniqueKey;
		console.log(currntHotelDetailId);
		var currntHotelRoomlId = 'roomresult-'+uniqueKey;

		var isVisible = $('#'+currntHotelDetailId).is(':visible');

		if(isVisible){
			$('#'+currntHotelDetailId).hide();
		}
		else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
			
			$('#'+currntHotelDetailId).show();
			$('#'+visibleHotelDetailId).hide();
			$('#'+currntHotelRoomlId).empty();

			// console.log(visibleHotelDetailId+' '+currntHotelDetailId);

			var data = {
				"_token" : "{{ Session::token() }}",
				"index" :hotelIndex,
				"vendor" : vendor
			}

			// console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				url: "{{ urlHotelsRoomBuilder($urlVariable->packageHotelId) }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					// console.log(textStatus);
					if(xhr.status == 200){
						$('#'+currntHotelRoomlId).empty(responce);
						$('#'+currntHotelRoomlId).html(responce);
						// document.location.href = this.url;
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						var responceHtml = '<pre><div class="m-top-20"><h1>Sorry Something went wrong<h1></div></pre>'; 
						$('#'+currntHotelRoomlId).html(responceHtml);
					}
				},
			});
		}
		else{
			// $('#'+currntHotelDetailId+', #'+visibleHotelDetailId).toggle();
			alert('Error!!!');
		}

	})
</script>
{{-- /Choose Room --}}

{{-- Book Room --}}
<script>
	$(document).on('click', '.btn-bookRoom', function(){
		var bookIndex = $(this).attr('data-bookIndex');
		var vendor = $(this).attr('data-vendor');
		var data = {
			"_token" : "{{ Session::token() }}",
			"index" : bookIndex,
			"vendor" : vendor
		}
		
		$.ajax({
			type:"post",
			url: "{{ urlHotelsRoomBookBuilder($urlVariable->packageHotelId) }}",
			data: data,
			success: function(responce, textStatus, xhr) {
				alert("Room Booked you will be redirect to next cart or home");
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

	});
</script>
{{-- /Book Room --}}

{{-- Model PopUp --}}
<script>
	$(document).on('click', "[data-toggle='modal']", function(){
		var popupTarget = $(this).attr('data-target');
		var popupTitle = $(this).attr('data-title');
		var popupButton = $(this).attr('data-button');
		var popupBodyId = $(this).attr('data-bodyid');
		var popupBody = $('#'+popupBodyId).html();
		var popupSize = '';
		
		// alert(popupTitle+' '+popupTarget);

		if(popupTarget == '.bs-example-modal-sm'){
			popupSize = '2';
		}

		$('#myModalLabel'+popupSize).html(popupTitle);
		$('#myModalBody'+popupSize).empty();
		$('#myModalBody'+popupSize).html(popupBody);
		
		if(popupButton == 'false'){
			$('#myModalButton'+popupSize).hide();
		}
	})
</script>
{{-- /model PopUp --}}



