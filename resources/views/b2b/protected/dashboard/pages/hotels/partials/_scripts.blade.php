
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
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			postFgfAgoda({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}});
			tbtq({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}});
									sshtl({{$hotelRoute->hotel->id}}, {{$hotelRoute->id}});
		@endforeach

	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- autocomplete --}}
<script>
	$(document).on('keypress paste{{--keyup  keydown --}}', '#filter_search', function(e) {
		var name = $(this).val();
		if (name.length > 2) {
			var did = $('#tab_menu').find('.active').attr('data-did');
			url = '{{ url("dashboard/hotels/search/") }}/'+did+'?format=json&_token='+csrf_token;
			$(this).autocomplete({ source: url });
		}
	});
</script>

<script>
	$(document).on('autocompleteselect', '#filter_search', function (e, ui) {
		$('#loging_log').show();

		var did = $('#tab_menu').find('.active').attr('data-did');
		var rid = $('#tab_menu').find('.active').attr('data-rid');
		postSearchFgfA($(this).val(), did, rid);
    // alert();
	});
</script>
{{-- /autocomplete --}}

{{-- filter List.js--}}

{{-- <script>
	var filter = {
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			'hotel_{{ $hotelRoute->id }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = {
				valueNames: ['search-word']
			};
			@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
				if (targetList == {{ $hotelRoute->id }}) {
					this.hotel_{{ $hotelRoute->id }} = new List("hotel_{{ $hotelRoute->id }}_div", options);
				}
			@endforeach
		}
	}
	
</script> --}}

<script>

	<?php 
		$rid =  [];
		$did =  [];
		$idObject = [];
		foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {

			$idObject['hotel_'.$hotelRoute->id] = [
					'did' => $hotelRoute->hotel->id,
					'rid' => $hotelRoute->id,
				];
			$idObject['hotel_'.$hotelRoute->id]['next_did'] = 'NaN';
			$idObject['hotel_'.$hotelRoute->id]['next_rid'] = 'NaN';

			if ($hotelRouteKey+1 < $package->hotelRoutes->count()) {
				$idObject['hotel_'.$hotelRoute->id]['next_did'] = $package->hotelRoutes[$hotelRouteKey+1]->hotel->id;
				$idObject['hotel_'.$hotelRoute->id]['next_rid'] = $package->hotelRoutes[$hotelRouteKey+1]->id;
			}

			$rid[] = $hotelRoute->id;
			$did[] = $hotelRoute->hotel->id;
		}

		$idObject['did'] = $did;
		$idObject['rid'] = $rid;
		$idObject = rejson_decode($idObject);
	?>
	var idObject = {!! json_encode($idObject) !!};
</script>

{{-- 
<script>
	$(document).on('keypress keyup keydown', "#filter_search", function(){
		var targetList = $('#tab_menu').find('.active').attr('data-list');
		// console.log(targetList);
		var search = $(this).val();
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			if (targetList == "hotel_{{ $hotelRoute->id }}_div") {
				filter.hotel_{{ $hotelRoute->id }}.search(search);
			}
		@endforeach

		/*if($('.list').children().length === 0) { // Checking if list is empty

			$('.not-found').css('display', 'block'); // Display the Not Found message

		} else {

			$('.not-found').css('display', 'none'); // Hide the Not Found message

		}*/
	});

</script>--}}
{{-- /filter List.js --}}



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

@include('b2b.protected.dashboard.pages.hotels.partials.fgf_agoda')
@include('b2b.protected.dashboard.pages.hotels.partials.fgf_agoda_rooms')
@include('b2b.protected.dashboard.pages.hotels.partials.tbtq')
@include('b2b.protected.dashboard.pages.hotels.partials.skyscanner')
@include('b2b.protected.dashboard.pages.hotels.partials.js_room')


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
