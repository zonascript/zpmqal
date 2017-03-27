
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		$('.datepicker').daterangepicker({
			singleDatePicker: true,
			calender_style: "picker_3",
			format : "D/M/YYYY",

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
								// var child_elem = $("#age_temp").html();
								// console.log(child_elem);
								// $("[data-age='"+fieldName+"']").append(child_elem);
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

{{-- autocomplete --}}
<script>
	$(function() {
		$(document).on('click', '.input-airport', function(){
			console.log($(this).attr('placeholder'));
			$(this).autocomplete({
				source: '{{ url("dashboard/tools/airport") }}'
			});
		});
	});
</script>
{{-- /autocomplete --}}

{{-- autocomplete --}}
<script>
	$(function() {
		$(document).on('click', '.btn-airport', function(){

			var origin = $('input.origin').val();
			var destination = $('input.destination').val();
			var arrival = $('input.arrival').val();
			var adult = $('input.adult').val();
			var child = $('input.child').val();
			var infant = $('input.infant').val();

			var data = {
					"_token" : "{{ Session::token() }}",
					"origin" : origin,
					"destination" : destination,
					"arrival" : arrival,
					"adult" : adult,
					"child" : child,
					"infant" : infant,
				}

			console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				url: "{{ urlFlightsSearch($urlVariable->flightDbId) }}",
				data: data,
				success: function(responce, textStatus, xhr) {
					console.log(responce);
					var responce = JSON.parse(responce);
         	document.location.href = responce.nextUrl;
        },

        error: function(xhr, textStatus) {
					// console.log(textStatus);
					// console.log(xhr.status);
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
        },

			});

		});
	});
</script>
{{-- /autocomplete --}}



{{-- filter List.js--}}
<script>
	var options = {
		valueNames: [ 'flightName', 'flightPrice']
	};

	var flightResultList = new List('flightsResult', options);

	$('.filterSelect').change(function(){
		var selection = $(this).val();
		$('#filterButton').attr('data-sort', selection);
		$('#filterButton').click();
	});
</script>
{{-- /filter List.js --}}

{{-- Choose Flight --}}
<script>
	$(document).on('click','.btn-chooseRoom', function(){
		
		var hotelIndex = $(this).attr('data-hotelIndex');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var visibleHotelDetailId = $('.classHotelDetail:visible').attr('id');
		var currntHotelDetailId = 'hoteldetail-'+hotelIndex;
		var currntHotelRoomlId = 'roomresult-'+hotelIndex;

		var isVisible = $('#'+currntHotelDetailId).is(':visible');

		if(isVisible){
			$('#'+currntHotelDetailId).hide();
		}
		else if(visibleHotelDetailId == undefined || visibleHotelDetailId != currntHotelDetailId){
			
			$('#'+currntHotelDetailId).show();
			$('#'+visibleHotelDetailId).hide();
			$('#'+currntHotelRoomlId).empty();

			console.log(visibleHotelDetailId+' '+currntHotelDetailId);

			var data = {
				"_token" : "{{ Session::token() }}",
				"Index" :hotelIndex,
			}

			// console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				{{-- url: "{{ url('dashboard/package/builder/hotel/room/'.$urlVariable->id.'/'.$urlVariable->packageDbId.'/'.$urlVariable->packageHotelId) }}", --}}
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
{{-- /Choose Flight --}}

{{-- Book Flight --}}
<script>
	$(document).on('click', '.btn-bookFlight', function(){
		var bookIndex = $(this).attr('data-bookIndex');
		var vendor = $(this).attr('data-vendor');
		var data = {
			"_token" : "{{ Session::token() }}",
			"index" :bookIndex,
			"vendor" : vendor
		}
		
		$.ajax({
			type:"post",
			url: "{{ str_replace('/result/', '/book/', Request::url()) }}",
			data: data,
			success: function(responce, textStatus, xhr) {
				// alert("Room Booked.");
				responce = JSON.parse(responce);
				console.log(responce);
				if (responce.status == 200) { 
					if (confirm('Go to the next')) {
							// yes 
					    document.location.href = responce.nextUrl;
					} else {
					    // now
					    document.location.href = responce.packageUrl;
					}
				}
				else{
					alert(responce.responce);
				}


				// console.log(responce);
				// if(xhr.status == 200){
				// 	$('#'+currntHotelRoomlId).empty(responce);
				// 	$('#'+currntHotelRoomlId).html(responce);
				// 	// document.location.href = this.url;
				// }
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
			},
		});

	});
</script>
{{-- /Book Flight --}}

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