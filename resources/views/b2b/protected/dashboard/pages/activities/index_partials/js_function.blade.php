<?php
	$activityStack = view('b2b.protected.dashboard.pages.activities.index_partials.html')->render();
	$activityStack = trimHtml($activityStack);
?>
@include('b2b.protected.dashboard.pages.activities.index_partials.js_act')

<script>
	function getRidObj(rid) {
		return idObject['activities_'+rid];
	}
</script>

<script>
	function getDateObject(rid) {
		return datesObject['rid_'+rid];
	}
</script>


<script>
	function getModeOption(key = '') {
		var modeOption = '';
		
		$.each(modeObj, function(mI,mV){
			var isSelectedWord = '';
			if (mI == key) {
				isSelectedWord = 'selected';
			}
			modeOption += '<option value="'+mI+'" '+isSelectedWord+'>'+mV+'</option>';
		});
		return modeOption;
	}
</script>



<script>
	function getTimingOption(key = '') {
		var timingOption = '';
		$.each(timingObj, function(mI,mV){
			var isSelectedWord = '';
			if (mI == key) {
				isSelectedWord = 'selected';
			}
			timingOption += '<option value="'+mI+'" '+isSelectedWord+'>'+mV+'</option>';
		});
		return timingOption;
	}
</script>


{{-- short string --}}
<script>
	function shortString(string, start = 0, word = 350) {
		if (string !=  null) {
			string = string.substring(start, word);
		}
		return string;
	}
</script>
{{-- short string --}}


{{-- get activity stack --}}
<script>
	function getActivityStack(activity) {
		var appendHtml = '';
		var searchWord = '';
		appendHtml = '{!! $activityStack !!}';
		return appendHtml;
	}
</script>
{{-- get activity stack --}}

{{-- select activity --}}
<script>
	function selectActivity(thisObj) {
		var parent = $(thisObj).closest('.activityContainer');
		var code = $(thisObj).attr('data-code');
		var isSelected = $(thisObj).attr('data-selected');
		var did = $(thisObj).attr('data-did');
		var rid = $(thisObj).attr('data-rid');
		var activityDescription = $('.activityFullDescription').text().trim();
		console.log(activityDescription);
		console.log($(parent).find('.activitySortDescription'));

		if (isSelected == 0) {

			$('#saveActivities').attr({ "data-did":did, "data-rid":rid });

			$(thisObj).attr('data-selected', 1);
			$(thisObj).text('Remove');
			$(thisObj).addClass('btn-danger');
			$(thisObj).removeClass('btn-primary');
			$(parent).addClass('border-green-3px');
			$(parent).find('.inputContainer_'+code).show();

			activityDescription.length > 0 
			? $(parent).find('.activitySortDescription').text(activityDescription.substring(0,90)+'...')
			: '';

		}else{
			$(thisObj).attr('data-selected', 0);
			$(thisObj).text('Add');
			$(thisObj).addClass('btn-primary');
			$(thisObj).removeClass('btn-danger');
			$(parent).removeClass('border-green-3px');
			$(parent).find('.inputContainer_'+code).hide();
			activityDescription.length > 0 
			? $(parent).find('.activitySortDescription').text(activityDescription.substring(0,350)+'...')
			: '';
		}
	}
</script>
{{-- /select activity --}}

{{-- addDropzone --}}
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
{{-- /addDropzone --}}

{{-- make Own ActivitiesJson --}}
<script>
	function makeOwnActivitiesJson(rid) {
		var elemid = 'activities_'+rid;
		var ridObj = getRidObj(rid);
		var did = ridObj.did;
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
{{-- /make Own ActivitiesJson --}}


{{-- initDatePicker --}}
<script>
	function initDatePicker(rid) {
		var cb = function(start, end, label) {
			console.log(start.toISOString(), end.toISOString(), label);
		};

		@foreach ($package->hotelRoutes as $hotelRouteKey => $hotelRoute)
			
			<?php 
				$startDate = $hotelRoute->start_datetime->format('Y-m-d');
				$endDate = $hotelRoute->end_datetime->format('Y-m-d');
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
{{-- /initDatePicker --}}


{{-- making activity json --}}
<script>
	function makeActivitiesJson(rid) {
		var elemid = 'activities_'+rid;
		var ridObj =  getRidObj(rid);
		var next_rid = ridObj.next_rid;
		var did = ridObj.did;
		var activitiesData = [];
		var isAllDateSelected = true;

		$('#'+elemid).each(function () {
			$(this).find('.border-green-3px').each(function(){

				var mode = $(this).find('.mode').val();
				var timing = $(this).find('.act-timing').val();
				var date = $(this).find('.datepicker').val();
				var vendor = $(this).attr('data-vendor');
				var activityCode = $(this).attr('data-code');

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

				activitiesData.push({
						'mode' : mode,
						'date' : date,
						'timing' : timing, 
						'vendor' : vendor,
						'activityCode' : activityCode
					});
			});
			
			var ownActivities = makeOwnActivitiesJson(rid);

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
{{-- /making activity json --}}

