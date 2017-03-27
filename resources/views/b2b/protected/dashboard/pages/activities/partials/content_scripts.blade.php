
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		var cb = function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		};

		@foreach ($activitiesSlices as $activitiesSlice_key => $activitiesSlice)
			
			<?php 
				$startDate = $activitiesSlice->model->start_date;
				$endDate = $activitiesSlice->model->end_date;
			?>

			var optionSet{{ $activitiesSlice_key }} = {
				singleDatePicker: true,
				calender_style: "picker_1",
				format : "D/M/YYYY",
				minDate : "{{ date_formatter($startDate, 'Y-m-d', 'd-m-Y') }}",
				maxDate : "{{ date_formatter($endDate, 'Y-m-d', 'd-m-Y') }}",
				startDate: new Date('{{ $startDate }}'),
				endDate: new Date('{{ $endDate }}'),
			};

			$('.datepicker-{{ $activitiesSlice_key }}').daterangepicker(optionSet{{ $activitiesSlice_key }}, cb);

		@endforeach
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
			activityIndex = $(this).attr('data-Index');
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
					// changeActivityPrice(activityIndex);
					changeActivityPrice($(this));
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

{{-- Activity Select Button --}}
<script>
	$(document).on('click', '.btn-activitySelect', function(){
		var activityIndex = $(this).attr('data-Index');
		var uniqueId = $(this).attr('data-uniqueid');
		var isSelected = $(this).attr('data-selected');
		var activityDescription = $('#activityFullDescription_'+uniqueId).text().trim();
		// console.log(isSelected);
		// console.log("activityDescription [ "+activityDescription+"]");
		console.log(activityDescription.length);
		if (isSelected == 0) {
			$(this).attr('data-selected', 1);
			$(this).text('Remove');
			$(this).addClass('btn-danger');
			$(this).removeClass('btn-primary');
			$('#container_'+uniqueId).addClass('border-green-3px');
			$('#inputContainer_'+uniqueId).show();
				activityDescription.length > 0 
				? $('#activitySortDescription_'+uniqueId).text(activityDescription.substring(0,90)+'...')
				: '';

		}else{
			$(this).attr('data-selected', 0);
			$(this).text('Add');
			$(this).addClass('btn-primary');
			$(this).removeClass('btn-danger');
			$('#container_'+uniqueId).removeClass('border-green-3px');
			$('#inputContainer_'+uniqueId).hide();
				activityDescription.length > 0 
				? $('#activitySortDescription_'+uniqueId).text(activityDescription.substring(0,600)+'...') 
				: '';
		}
	});
</script>
{{-- /Activity Selection --}}

{{-- Changing Tour Type --}}
<script>
	$(document).on('change', '.tourType', function(){
		var thisVal = $(this).val();
		var activityIndex = $(this).attr('data-Index');
		if (thisVal == 'private') {
			$('#privateCar_'+activityIndex).show();
		}else{
			$('#privateCar_'+activityIndex).hide();
		}
		changeActivityPrice($(this));
		// console.log('thisVal = '+thisVal+' activityIndex = '+activityIndex);
	});
</script>
{{-- /Changing Tour Type --}}

{{-- changing Car --}}
<script>
	$(document).on('change','.privateCar', function(){
		// var activityIndex = $(this).attr('data-Index');
		changeActivityPrice($(this));
		// console.log('activityIndex = '+activityIndex);
	});
</script>
{{-- /changing Car --}}

{{-- Save Activities --}}
<script>
	$(document).on('click', '#saveActivities', function(){
		if (confirm('Are you sure want to save Activity?')) {

			var activitiesData = [];
			var isAllDateSelected = true;

			$('.border-green-3px').each(function(){
				var dataObj = $(this).data();
				console.log(dataObj);
				
				var adultCount = $(this).find('input.adult').val();
				var childCount = $(this).find('input.child').val();
				var sliceIndex = dataObj.mainindex/* $(this).attr('data-mainIndex')*/;
				var activityIndex = dataObj.index /*$(this).attr('data-Index')*/;
				var activityCode = dataObj.activitycode /*$(this).attr('data-activityCode')*/;

				var date = $(this).find('.datepicker').val();
				var currency = $(this).find('.currency').text().trim();
				var activityPrice = $(this).find('.activityPrice').text().trim();

				if (date == '') {
					isAllDateSelected = false;
					return false;
				}
				if (dataObj.vendor == 'fgf') {
					var tourType = $(this).find('select.tourType').val();
					var privateCarCode = 'NaN';
					var privateCarPrice = 'NaN';
					var privateCarCount = 'NaN';
					var privateCarIndex = 'NaN';

					if (tourType == 'private') {
						privateCarPrice = $(this).find('select.privateCar').val();
						privateCarCode = $(this).find('select.privateCar option:selected').attr('data-carCode');
						privateCarIndex = $(this).find('select.privateCar option:selected').attr('data-carIndex');
						privateCarCount = $(this).find('select.privateCar option:selected').attr('data-carCount');
					}

					var privateCar = {
						"code" : privateCarCode,
						"index" : privateCarIndex,
						"count" : privateCarCount,
						"price" : privateCarPrice
					}

					activitiesData.push({
						'vendor' : 'fgf',
						'sliceIndex' : sliceIndex,
						'activityCode' : activityCode, 
						'index': activityIndex,
						'tourType' : tourType,
						'date' : date,
						'adultCount' : adultCount,
						'childCount' : childCount,
						'currency' : currency,
						'finalPrice' : activityPrice,
						'privateCar' : privateCar,
					});
				}
				else if(dataObj.vendor == 'viator'){
					activitiesData.push({
						'vendor' : 'viator',
						'sliceIndex' : sliceIndex,
						'activityCode' : activityCode, 
						'index': activityIndex,
						'date' : date,
						'adultCount' : adultCount,
						'childCount' : childCount,
						'currency' : currency,
						'finalPrice' : activityPrice,
					});
				}
			});

			console.log('activitiesData = '+JSON.stringify(activitiesData));

			if (isAllDateSelected) {
				$.ajax({
					type: "POST",
					url: "{{urlActivitiesBuilder($urlVariable->packageDbId)}}",
					data: {"_token": "{{csrf_token()}}","activitiesData" : activitiesData},
					cache: false,
					success: function(html) {   
						document.location.href = "{{ urlPackageAll($urlVariable->id, $urlVariable->packageDbId) }}";
					} 
				});
			}else{
				alert('Choose every selected date first...');
			}
		} 
		else {

		}
		

	});
</script>
{{-- /Save Activities --}}

{{-- fixing price on load --}}
<script>
	$(document).ready(function() {
		$('.border-green-3px').each(function(){
			// var activityIndex = $(this).attr('data-Index');
			changeActivityPrice($(this));
		});
	});
</script>
{{-- /fixing price on load --}}

{{-- function for Change Price --}}
<script>
	function changeActivityPrice(thisObj) {
		console.log(thisObj.data());
		var dataObj = thisObj.data();
		var index = dataObj.vendor == 'viator' ? 'v_'+dataObj.index : dataObj.index;

		var adultCount = $('#adult_'+index).val();
		var childCount = $('#child_'+index).val();

		if (dataObj.vendor == 'fgf') {
			
			var tourType = $('#tourType_'+index).val();
			var isCar = $('#tourType_'+index).find(':selected').attr('data-car');
			var adultPrice = $('#tourType_'+index).find(':selected').attr('data-adult');
			var childPrice = $('#tourType_'+index).find(':selected').attr('data-child');

			if(tourType == 'sic'){
				var activityPrice = (adultCount*adultPrice+childCount*childPrice).toFixed(1);
				$('#activityPrice_'+index).text(activityPrice);

			}else if(tourType == 'private'){
				var carPrice = isCar == 1 ? $('#privateCar_'+index).val() : 0;
				var activityPrice = (adultCount*adultPrice+childCount*childPrice+carPrice*2).toFixed(1);

				$('#activityPrice_'+index).text(activityPrice);
			}
		}
		else if(dataObj.vendor == 'viator'){
			
			var adultPrice = $('#activityPrice_'+index).attr('data-price');
			var childPrice =  adultPrice*.60;
			
			var activityPrice = (adultCount*adultPrice+childCount*childPrice).toFixed(1);
			$('#activityPrice_'+index).text(activityPrice);
		}
	}
</script>
{{-- / function for Change Price --}}



<script>
	function changeActivityPriceNew(index){

		if (vendor == 'fgf') {
			var adultCount = $('#adult_'+index).val();
			var childCount = $('#child_'+index).val();
			var tourType = $('#tourType_'+index).val();
			var isCar = $('#tourType_'+index).find(':selected').attr('data-car');
			var adultPrice = $('#tourType_'+index).find(':selected').attr('data-adult');
			var childPrice = $('#tourType_'+index).find(':selected').attr('data-child');

			if(tourType == 'sic'){
				var activityPrice = (adultCount*adultPrice+childCount*childPrice).toFixed(1);
				$('#activityPrice_'+index).text(activityPrice);

			}else if(tourType == 'private'){
				var carPrice = isCar == 1 ? $('#privateCar_'+index).val() : 0;
				var activityPrice = (adultCount*adultPrice+childCount*childPrice+carPrice*2).toFixed(1);

				$('#activityPrice_'+index).text(activityPrice);
			}
		}
		else if(vendor == 'viator'){

		}

		//console.log("adultCount = "+adultCount+" childCount = "+childCount+' tourType = '+tourType+' adultPrice = '+adultPrice+' childPrice = '+childPrice+' carPrice = '+carPrice+' activityPrice = '+activityPrice);
	}
</script>




