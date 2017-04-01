
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

		/*postSsFlight({{$package->flightRoutes[0]->id}});*/
		postQpxFlight({{$package->flightRoutes[0]->id}});

	});
</script>
{{-- /bootstrap-daterangepicker --}}

{{-- autocomplete --}}
<script>
	$(document).on('keyup keypress keydown paste', '.input-airport', function(){
		$(this).autocomplete({
			source: '{{ url("dashboard/tools/airport") }}'
		});
	});
</script>
{{-- /autocomplete --}}

{{-- modify search --}}
<script>
	$(document).on('click', '#modify_search', function(){
		$('#loging_log').show();
		var rid = $(this).attr('data-rid');
		var origin = $('input.origin').val();
		var destination = $('input.destination').val();
		changeTabMenu(rid, origin, destination);

		idObject['flight_'+rid].origin = origin;
		idObject['flight_'+rid].destination = destination;
		
		{{--var arrival = $('input.arrival').val();
		var adult = $('input.adult').val();
		var child = $('input.child').val();
		var infant = $('input.infant').val();--}}

		var data = {
				"_token" : csrf_token,
				"origin" : origin,
				"destination" : destination,
				{{--"arrival" : arrival,
				"adult" : adult,
				"child" : child,
				"infant" : infant,--}}
			};

		$.ajax({
			type:"post",
			url: "{{url('dashboard/package/route/update/')}}/"+rid+"?format=json",
			data: data,
			success: function(response) {
				var response = JSON.parse(response);
				/*console.log(response);*/
				if (response.status == 200) {
					$('#flight_'+rid).empty();
					postQpxFlight(rid);
					/*postSsFlight(rid);*/
				}
      }
		});
	});
</script>
{{-- /modify search --}}

@include('b2b.protected.dashboard.pages.flights.partials.js_objects')

{{-- filter List.js--}}
<script>
	var filter = {
		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
			'flight_{{ $flightRoute->id }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = {
				valueNames: ['search-word']
			};
			@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
				if (targetList == {{ $flightRoute->id }}) {
					this.flight_{{ $flightRoute->id }} = new List("flight_{{ $flightRoute->id }}_div", options);
				}
			@endforeach
		}
	}

</script>
<script>
	$(document).on('keypress keyup keydown', "#filter_search", function(){
		var targetList = $('#tab_menu').find('.active').attr('data-list');
		console.log(targetList);
		var search = $(this).val();
		@foreach ($package->flightRoutes as $flightRouteKey => $flightRoute)
			if (targetList == "flight_{{ $flightRoute->id }}_div") {
				filter.flight_{{ $flightRoute->id }}.search(search);
			}
		@endforeach
	});
</script>
{{-- /filter List.js --}}


{{-- Book Flight --}}
<script>
	$(document).on('click', '.btn-addtocart', function(){
		$('#loging_log').show();

		$(this).addClass('btn-danger');
		$(this).removeClass('btn-primary');
		$(this).text('Delete');

		var parent = $(this).closest('.tab-pane');
		$(parent).find('.btn-addtocart.btn-primary').addClass('btn-dark');
		$(parent).find('.btn-addtocart.btn-primary').removeClass('btn-primary');
		{{-- $('.btn-addtocart.btn-primary').prop('disabled', false); --}}

		var id = $(this).attr('data-id');
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		var vendor = $(this).attr('data-vendor');
		var elemId = 'flight_'+rid;
		var ridObject = getRidObject(rid);
		var next_did = ridObject.next_did;
		var next_rid = ridObject.next_rid;

		var data = {
				"_token" : csrf_token,
				"did" : did,
				"index" :id,
				"next_rid" : next_rid,
				"vendor" : vendor
			};
		
		postAddtoCartFlight(data);

		$(this).closest('.main-list-item').prependTo("#"+elemId);

		if (next_rid != "NaN") {
			setTimeout(function () {
				console.log(isPulled(next_rid));
				if (isPulled(next_rid) == 0) {
					postQpxFlight(next_rid);
					/*postSsFlight(next_rid);*/
				}else{
					$('#loging_log').hide();
				}
		  }, 3000)
		}else{
			setTimeout(function () {    
				document.location.href = "{{ url('/dashboard/package/builder/event/'.$package->id.'/flight') }}";
		  }, 10000)
		}
	});
</script>
{{-- /Book Flight --}}


<script>
	$(document).on('click', '.a_tab_menu',function () {
		var rid = $(this).attr('data-rid');
		var ridObject = getRidObject(rid);
		var origin = ridObject.origin;
		var destination = ridObject.destination;
		$('#modify_origin').val(origin);
		$('#modify_destination').val(destination);
		$('#modify_search').attr('data-rid', rid);
	});
</script>

{{-- refreash flights --}}
<script>
	$(document).on('click', '.refreash-flights', function() {
		var vendor = $(this).attr('data-vendor');
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		if (vendor == 'qpx') {
			postQpxFlight(rid);
		}
		else if (vendor == 'ss') {
			postSsFlight(rid);
		}
	});
</script>
{{-- /refreash flights --}}

{{-- Adults-Child-button --}}
<script>
	/*plugin bootstrap minus and plus
	http://jsfiddle.net/laelitenetwork/puJ6G/*/
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
								/*var child_elem = $("#age_temp").html();
								console.log(child_elem);
								$("[data-age='"+fieldName+"']").append(child_elem);*/
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
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
					(e.keyCode == 65 && e.ctrlKey === true) || 
					(e.keyCode >= 35 && e.keyCode <= 39)) {
							 return;
			}
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
			}
	});
</script>
{{-- /Adults-Child-button --}}

@include('b2b.protected.dashboard.pages.flights.partials.js_function')
