
{{-- bootstrap-daterangepicker --}}
<script>
	$(document).ready(function() {
		
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
		 	@if ($hotelRouteKey)
				setTimeout(function () {   
					uniActivities({{$hotelRoute->activities->id}}, {{$hotelRoute->id}});
			 	}, {{ 3000*($hotelRouteKey+1) }})
		 	@else
				uniActivities({{$hotelRoute->activities->id}}, {{$hotelRoute->id}});
		 	@endif
		@endforeach

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
					"_token" : "{{ Session::token() }}",
					"origin" : origin,
					"destination" : destination,
					"arrival" : arrival,
					"adult" : adult,
					"child" : child,
					"infant" : infant,
				}

			// console.log(JSON.stringify(data));

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
					// console.log(textStatus);
					// console.log(xhr.status);
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
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			'activities_{{ $hotelRoute->id }}' : '',
		@endforeach
		initFilter : function (targetList) {
			var options = {
				valueNames: ['search-word']
			};
			@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
				if (targetList == {{ $hotelRoute->id }}) {
					this.activities_{{ $hotelRoute->id }} = new List("activities_{{ $hotelRoute->id }}_div", options);
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
		foreach ($package->hotelRoutes as $hotelRouteKey  => $hotelRoute) {

			$idObject['activities_'.$hotelRoute->id] = [
					'did' => $hotelRoute->activities->id,
					'rid' => $hotelRoute->id,
				];
			$idObject['activities_'.$hotelRoute->id]['next_did'] = 'NaN';
			$idObject['activities_'.$hotelRoute->id]['next_rid'] = 'NaN';

			if ($hotelRouteKey+1 < $package->hotelRoutes->count()) {
				$idObject['activities_'.$hotelRoute->id]['next_did'] = $package->hotelRoutes[$hotelRouteKey+1]->activities->id;
				$idObject['activities_'.$hotelRoute->id]['next_rid'] = $package->hotelRoutes[$hotelRouteKey+1]->id;
			}

			$rid[] = $hotelRoute->id;
			$did[] = $hotelRoute->activities->id;
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
		// console.log(targetList);
		var search = $(this).val();
		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			if (targetList == "activities_{{ $hotelRoute->id }}_div") {
				filter.activities_{{ $hotelRoute->id }}.search(search);
			}
		@endforeach
	});

</script>
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

@include('b2b.protected.dashboard.pages.activities.index_partials.union')

{{-- Adults-Child-button --}}
<script>
	//plugin bootstrap minus and plus
	//http://jsfiddle.net/laelitenetwork/puJ6G/
	$('.btn-number').click(function(e){
			e.preventDefault();
			
			var type = $(this).attr('data-type');
			var dataName = $(this).attr('data-name');
			var fieldName = $(this).attr('data-field');
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


<script>
	function star_Rating(count){
		var stars = '';
		for (var i = 0; i < 5; i++) {
			if (i <= count) {
				stars += '<i class="fa fa-star font-gold font-size-13"></i>';
			}else{
				stars += '<i class="fa fa-star font-size-13"></i>';
			}
		}
		return stars;
	}
</script>


{{-- Activity Select Button --}}
<script>
	$(document).on('click', '.btn-activitySelect', function(){
		var activityIndex = $(this).attr('data-Index');
		var uniqueId = $(this).attr('data-uniqueid');
		var isSelected = $(this).attr('data-selected');
		var activityDescription = $('#activityFullDescription_'+uniqueId).text().trim();
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		// console.log(isSelected);
		// console.log("activityDescription [ "+activityDescription+"]");
		// console.log(activityDescription.length);
		if (isSelected == 0) {
			$('#saveActivities').attr('data-did', did);
			$('#saveActivities').attr('data-rid', rid);
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
				? $('#activitySortDescription_'+uniqueId).text(activityDescription.substring(0,350)+'...') 
				: '';
		}
	});
</script>
{{-- /Activity Selection --}}


{{-- Save Activities --}}
<script>
	$(document).on('click', '#saveActivities', function(){
		/*var rid = $(this).attr('data-rid');
		var did = $(this).attr('data-did');
		if (rid == '') {*/
			rid = $('.li-menu-dest.active').attr('data-rid');
			did = $('.li-menu-dest.active').attr('data-did');
		/*}*/
		makeActivitiesJson(rid, did);
	});
</script>
{{-- /Save Activities --}}

<script>
	function makeActivitiesJson(rid, did) {
		var elemid = 'activities_'+rid;
		var next_rid = idObject[elemid].next_rid;
		var activitiesData = {};
		var isAllDateSelected = true;
		console.log($('#'+elemid));
		$('#'+elemid).each(function () {
			$(this).find('.border-green-3px').each(function(){

				var mode = $(this).find('.mode').val();
				var timing = $(this).find('.act-timing').val();
				var date = $(this).find('.datepicker').val();
				var vendor = $(this).attr('data-vendor');
				var activityCode = $(this).attr('data-activitycode');

				$(this).find('.border-red').removeClass('border-red');

				if (date == '') {
					$(this).find('.datepicker').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}

				if (mode == '' || mode == 'Mode') {
					$(this).find('.mode').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}

				if (timing == '' || timing == 'Timing') {
					$(this).find('.act-timing').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}

				activitiesData[activityCode] = {
						'mode' : mode,
						'date' : date,
						'timing' : timing, 
						'vendor' : vendor,
						'activityCode' : activityCode
					};
			});
			
			var ownActivities = makeOwnActivitiesJson(rid, did);

			/*if (ownActivities == false) {
				isAllDateSelected = false;
			}*/

			/*console.log('activitiesData = '+JSON.stringify(activitiesData));*/

			if (isAllDateSelected) {
				var data = {
						"_token": csrf_token,
						"activities" : activitiesData,
						"own_activities" : ownActivities
					};
				
				console.log(data);

				$.ajax({
					type: "POST",
					url: "{{url('/dashboard/package/builder/activities/save/')}}/"+did,
					data: data,
					cache: false,
					success: function(html) { 
						if (next_rid == "NaN") {
							document.location.href = "{{ urlPackageAll($package->client->id, $package->id) }}";
						}else{
							$('#a_activities_'+next_rid).click();
						}
					} 
				});
			}else{
				alert('Provide selected data...');
			}
		});
	}
</script>


<script>
	function initDatePicker(rid) {
		var cb = function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		};

		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			
			<?php 
				$startDate = date_formatter($hotelRoute->start_date, 'Y-m-d H:i:s');
				$endDate = date_formatter($hotelRoute->end_date, 'Y-m-d H:i:s');
				$minDate = date_differences($hotelRoute->start_date,date("Y-m-d"));
				$maxDate = date_differences($hotelRoute->end_date,date("Y-m-d"));
			?>

			if (rid == {{$hotelRoute->id}}) {
				var optionSet{{ $hotelRoute->id }} = {
					singleDatePicker: true,
					calender_style: "picker_1",
					format : "DD/MM/YYYY",
					minDate : moment('{{ $startDate }}'),
					maxDate : moment('{{ $endDate }}'),
					startDate: new Date('{{ $startDate }}'),
					endDate: new Date('{{ $endDate }}')
				};

				$('.datepicker-{{ $hotelRoute->id }}').daterangepicker(optionSet{{ $hotelRoute->id}}, cb);
			}
		@endforeach
	};
</script>

<script>
	$(document).on('click', '.add-own-activity', function() {
		var did = $(this).attr('data-did');
		var rid = $(this).attr('data-rid');
		var count = $(this).attr('data-count');
		var uniqueId = rid+'_'+count;
		count = parseInt(count)+1;
		$(this).attr('data-count', count);
		var elemid = 'activities_'+rid;
		<?php 
			$addActiviyHtml = view('b2b.protected.dashboard.pages.activities.index_partials._add')
					->render();
			$addActiviyHtml = trimHtml($addActiviyHtml);
		?>
		var html = '{!! $addActiviyHtml !!}';
		$('#'+elemid).append(html);
		addDropzone('#uploadform_'+uniqueId);
		initDatePicker(rid);
	});
</script>


<script>
	/*--Asking premission for delete--*/
	$(document).on('click', '.btn-remove-own', function() {
		uid = $(this).attr('data-uid');
		$('#btn_confirmed_activity').attr('data-uid', uid);
	});

	/*--Removed after confirmed--*/
	$(document).on('click', '#btn_confirmed_activity', function () {
		uid = $(this).attr('data-uid');
		$('#own_activity_'+uid).remove();
	})
</script>


<script>
	function addDropzone(elemid) {
		Dropzone.autoDiscover = false; // keep this line if you have multiple dropzones in the same page
		$(elemid).dropzone({	
			acceptedFiles: "image/*",
			url: '{{ url('image/upload') }}',
			maxFiles: 1, // Number of files at a time
			maxFilesize: 2, //in MB
			maxfilesexceeded: function(file) {
				alert('You have uploaded more than 1 Image. Only the first file will be uploaded!');
			},
			success: function (response) {
				// console.log(response.xhr.responseText);
				var x = JSON.parse(response.xhr.responseText);
				$(this.element).attr('data-host', x.host)
				$(this.element).attr('data-path', x.path)
				$(this.element).removeClass('bg-color-gray');
				/*console.log($(this.element));*/
			},		
			addRemoveLinks: true,
			removedfile: function(file) {
				var _ref;
				$(this.element).addClass('bg-color-gray');
				return (_ref = file.previewElement) != null 
							? _ref.parentNode.removeChild(file.previewElement) 
							: void 0;  
			}	
			
		});
	}
</script>

<script>
	function makeOwnActivitiesJson(rid, did) {
		var elemid = 'activities_'+rid;
		var activitiesData = [];
		var isAllDateSelected = true;

		$('#'+elemid).each(function () {
			$(this).find('.border-blue-1px').each(function(){
				var vendor = $(this).attr('data-vendor');
				var mode = $(this).find('.mode').val();
				var timing = $(this).find('.timing').val();
				var date = $(this).find('.datepicker').val();
				var name = $(this).find('.activity-name').val();
				var description = $(this).find('.activity-description').val();
				var image = $(this).find('.uploadform').attr('data-path');

				$(this).find('.border-red').removeClass('border-red');

				if (date == '') {
					$(this).find('.datepicker').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}

				if (mode == '') {
					$(this).find('.mode').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}

				if (timing == '') {
					$(this).find('.timing').addClass('border-red');
					isAllDateSelected = false;
					return false;
				}
				var tempData = {
						'mode' : mode,
						'date' : date,
						'name' : name,
						'timing' : timing, 
						'vendor' : vendor,
						'image_path' : image,
						'description' : description
					};
				
				// console.log(tempData);

				activitiesData.push(tempData);
			});
		});

		if (isAllDateSelected) {
			return activitiesData;
		}else{
			return false;
		}
	}
</script>