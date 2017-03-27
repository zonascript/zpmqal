
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

		postSsFlight({{$package->flightRoutes[0]->flight->id}}, {{$package->flightRoutes[0]->id}}, 1);
		postQpxFlight({{$package->flightRoutes[0]->flight->id}}, {{$package->flightRoutes[0]->id}});

	});
</script>
{{-- /bootstrap-daterangepicker --}}

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
					"_token" : csrf_token,
					"origin" : origin,
					"destination" : destination,
					"arrival" : arrival,
					"adult" : adult,
					"child" : child,
					"infant" : infant,
				};

			console.log(JSON.stringify(data));

			$.ajax({
				type:"post",
				url: "",
				data: data,
				success: function(responce, textStatus, xhr) {
					console.log(responce);
					var responce = JSON.parse(responce);
         	document.location.href = responce.nextUrl;
        },

        error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
        }

			});

		});
	});
</script>
{{-- /autocomplete --}}

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

	<?php 
		$rid =  [];
		$did =  [];
		$idObject = [];
		foreach ($package->flightRoutes as $flightRouteKey  => $flightRoute) {

			$idObject['flight_'.$flightRoute->id] = [
					'did' => $flightRoute->flight->id,
					'rid' => $flightRoute->id,
				];
			$idObject['flight_'.$flightRoute->id]['next_did'] = 'NaN';
			$idObject['flight_'.$flightRoute->id]['next_rid'] = 'NaN';

			if ($flightRouteKey+1 < $package->flightRoutes->count()) {
				$idObject['flight_'.$flightRoute->id]['next_did'] = $package->flightRoutes[$flightRouteKey+1]->flight->id;
				$idObject['flight_'.$flightRoute->id]['next_rid'] = $package->flightRoutes[$flightRouteKey+1]->id;
			}

			$rid[] = $flightRoute->id;
			$did[] = $flightRoute->flight->id;
		}

		$idObject['did'] = $did;
		$idObject['rid'] = $rid;
		$idObject = rejson_decode($idObject);
	?>
	var idObject = {!! json_encode($idObject) !!};
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
		$(this).addClass('btn-primary');
		$(this).text('Delete');

		/*$('.btn-addtocart.btn-primary').addClass('btn-dark');
		$('.btn-addtocart.btn-primary').prop('disabled', false);
		$('.btn-addtocart.btn-primary').addClass('btn-primary');*/

		var id = $(this).attr('data-id');
		var did = $(this).attr('data-did');
		var vendor = $(this).attr('data-vendor');
		var elemId = $(this).attr('data-elemid');
		var rid = idObject[elemId].rid;
		var next_did = idObject[elemId].next_did;
		var next_rid = idObject[elemId].next_rid;
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
				/*postQpxFlight(next_did, next_rid, true);*/
				postSsFlight(next_did, next_rid, true);
		  }, 3000)
		}else{
			setTimeout(function () {    
				document.location.href = "{{ url('/dashboard/package/builder/event/'.$package->id.'/flight') }}";
		  }, 10000)
		}
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

@include('b2b.protected.dashboard.pages.flights.partials.qpx_script')
@include('b2b.protected.dashboard.pages.flights.partials.ss_script')

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

<script>
	$(document).on('click', '.refreash-flights', function() {
		var vendor = $(this).attr('data-vendor');
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		if (vendor == 'qpx') {
			postQpxFlight(did, rid);
		}
		else if (vendor == 'ss') {
			postSsFlight(did, rid);
		}

	});
</script>

<script>
	function postAddtoCartFlight(data) {
		/*Object must be like this 
		var data = {
			"_token" : csrf_token,
			"did" : did,
			"index" :id,
			"vendor" : vendor
		}*/
		$.ajax({
			type:"post",
			url: "{{ urlFlightBook()}}"+data.did,
			data: data,
			success : function(responce){
				responce = JSON.parse(responce);
				if (responce.status == 200) {
					$('#a_flight_'+data.next_rid).click();
				}else{
					alert('Something went wrong please try again.');
				}
			},
			error: function(xhr, textStatus) {
				if(xhr.status == 401){
					window.open("{{ url('login') }}", '_blank');
				}
				alert('Something went wrong please try again.');
			}
		});
	}
</script>


<script>
	function getDate(datetime) {
		return moment(datetime).format("DD-MM-YYYY");
	}

	function getTime(datetime) {
		return moment(datetime).format("HH:mm");
	}
</script>


<script>
	function refreashFlights(ids) {
		$('#loging_log').show();
		$('#'+ids.elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button data-vendor="'+ids.vendor+'" data-did="'+ids.did+'" data-rid="'+ids.rid+'" class="btn btn-primary btn-block refreash-flights">Refreash</button></div></div></div>');
	}
</script>