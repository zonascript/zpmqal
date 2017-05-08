
{{-- @include($viewPath.'.partials.scripts.act') --}}

<script>

	function getRidObj(rid) {
		return idObject['rid_'+rid];
	}


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


	function showDescription(thisObj) {
		var popupTitle = proper($(thisObj).attr('data-title'));
		var popupTarget = $(thisObj).attr('data-target');
		var popupBody = $(popupTarget).html();
		$.alert({
			backgroundDismiss: true,
			keyboardEnabled: true,
			title: popupTitle,
			content: popupBody,
			columnClass: 'col-md-6 col-md-offset-3'
		});
	}


	function postActivities(rid, type = 'fatch', term = '') {
		if (rid != '') {
			var getRidObject = getRidObj(rid);
			var elem_id = "rid_"+rid;
			var data = {
					"_token" : csrf_token,
					"term" : term
				};

			$.ajax({
				type:"post",
				url: "{{ url('api/package/activities') }}/"+type+'/'+rid,
				data: data,
				success: function(response, textStatus, xhr) {
					var response = JSON.parse(response);
					if (response.activities) {
						$('#loging_log').hide();
						$.each(response.activities, function(i,v){
							v['rid'] = rid;
							$('#'+elem_id).append(makeActivityObject(i, v));
						});
						initDatePicker(rid);
					}
					else{
						$('#'+elem_id).append('<p>Activities Not Found</p>');
					}
				},
				error: function(xhr, textStatus) {
					if(xhr.status == 401){
						window.open("{{ url('login') }}", '_blank');
					}
					else if(xhr.status == 500){
						$('#loging_log').hide();
						$('#'+elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button class="btn btn-primary btn-block" onclick="'+uniActivities(rid)+';">Refreash</button></div></div></div>');
					}
				}
			});

		}
	}

	function searchActivities() {
		var term = $('#filter_search').val();
		postActivities(idObject.crid, 'search', term);
		hideSpinIcon();
	}


	function makeActivityObject(i, obj) {
		var isExits = $('#rid_'+obj.rid).find('.li_'+obj.ukey);
		if (isExits.length > 0) {
			moveToTop(isExits);
		}
		else{
			var border = '';
			var date = '';
			var btnName = 'Add';
			var btnClass = 'btn-primary';
			var dateStyle = 'style="display: none;"';
			var modeOption = getModeOption(obj.mode);
			var timingOption = getTimingOption(obj.timing);
			var sortDescription = shortString(obj.description);
			var pdid = isset(obj, 'pdid') ? obj.pdid : '';

			if (obj.isSelected == 1) {
				border = 'border-green-3px';
				btnClass = 'btn-danger';
				btnName = 'Remove';
				dateStyle = '';
				date = moment(obj.date).format('DD/MM/YYYY');
				sortDescription = shortString(obj.description, 0, 150);
			}

			var activity = {
				'rid' : obj.rid,
				'pdid' : pdid,
				'date' : date,
				'ukey' : obj.ukey,
				'code' : obj.code,
				'name' : obj.name,
				'border' : border,
				'image' : obj.image,
				'btnName' : btnName,
				'btnClass' : btnClass,
				'vendor' : obj.vendor,
				'dateStyle' : dateStyle,
				'modeOption' : modeOption,
				'timingOption' : timingOption,
				'isSelected' : obj.isSelected,
				'description' : obj.description,
				'sortDescription' : sortDescription
			};

			return getActivityStack(activity);
		}
	}


	function moveToTop(thisObj) {
		var parent = $(thisObj).closest('.list.list-unstyled');
		$(parent).prepend(thisObj);

		$(thisObj).find('.x_panel.glowing-border').addClass('border-green-2px');
	}


	{{-- get activity stack --}}
	function getActivityStack(activity) {
		return '@include($viewPath.'.partials.scripts.html')';
	}
	{{-- get activity stack --}}


	{{-- select activity --}}
	function selectActivity(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		if ($(thisObj).hasClass('btn-primary')) {
			if (checkInputs(thisObj)) {
				addActivity(parent); {{-- should give parent object --}}
				showSortDescription(parent);

				$(thisObj).addClass('btn-danger unsaved')
										.text('Remove')
											.removeClass('btn-primary');
				$(parent).find('.x_panel.glowing-border')
									.addClass('border-green-3px')
										.find('.input-container')
											.show();
			}
		}
		else{
			$(thisObj).addClass('btn-primary')
									.text('Add')
										.removeClass('btn-danger');
			$(parent).find('.x_panel.glowing-border')
								.removeClass('border-green-3px')
									.find('.input-container')
										.hide();

			showFullDescription(parent);
			removeActivity(thisObj); {{-- should give btn object --}}
		}
	}
	{{-- /select activity --}}


	{{-- this is to show sort description --}}
	function showSortDescription(thisObj) {
		var desc = $(thisObj).find('.full-description').text().trim();
		if (desc.length > 0) {
			$(thisObj).find('.sort-description').text(desc.substring(0,90)+'...');
		}
	}
	{{-- this is to show sort description --}}


	{{-- this is to show full description --}}
	function showFullDescription(thisObj) {
		var desc = $(thisObj).find('.full-description').text().trim();
		if (desc.length > 0) {
			$(thisObj).find('.sort-description').text(desc.substring(0,350)+'...');
		}
	}
	{{-- this is to show full description --}}

	{{-- add activity --}}
	function addActivity(thisObj) {
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		var rid =  $(ulParent).attr('data-rid');
		$(ulParent).find('.btn-danger.unsaved').each(function () {
			var data = getActInputs(this);
			var btnObj = this;
			if (data == false) {
				return false;
			}
			else{
				data['_token'] = csrf_token;
				$.ajax({
					type:"post",
					url: "{{ urlActivitiesBuilder('add') }}/"+rid,
					data: data,
					success : function (response) {
						response = JSON.parse(response);
						$(btnObj).attr('data-pdid', response.pdid)
												.removeClass('unsaved');

					}
				});
			}
		});
	}
	{{-- /add activity --}}


	function removeActivity(thisObj) {
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		var rid =  $(ulParent).attr('data-rid');
		var pdid = $(thisObj).attr('data-pdid');
		var data = {
				'_token' : csrf_token,
				'pdid' : pdid
			};
		$.ajax({
			type:"post",
			url: "{{ urlActivitiesBuilder('remove') }}/"+rid,
			data: data,
			success : function (response) {
				response = JSON.parse(response);
				$(btnObj).attr('data-pdid', '')
										.removeClass('unsaved');
			}
		});
	}


	function showSpinIcon() {
		$('#fa_def_filter_icon').addClass('hide');
		$('#fa_spin_filter_icon').removeClass('hide');
	}

	function hideSpinIcon() {
		$('#fa_spin_filter_icon').addClass('hide');
		$('#fa_def_filter_icon').removeClass('hide');
	}

	
	function checkInputs(thisObj) {
		var result = true; {{-- if true then every thing is fine --}}
		var ulParent = $(thisObj).closest('.list.list-unstyled');
		$(ulParent).find('.btn-danger.unsaved').each(function () {
			if (getActInputs(this) == false) {
				result = false;
				return false;
			}
		});

		return result;
	}




	function getDate(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.datepicker');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}


	function getTiming(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.act-timing');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}


	function getMode(thisObj) {
		var parent = $(thisObj).closest('.activity-container');
		var element = $(parent).find('.mode');
		var value = $(element).val();
		if (value == '') {
			$(parent).get(0).scrollIntoView();
			$(element).addClass('border-red');
			return false;
		}
		else{
			$(element).removeClass('border-red');
			return value;
		}
	}



	function getActInputs(thisObj) {
		var date = getDate(thisObj);
		var mode = getMode(thisObj);
		var timing = getTiming(thisObj);
		if (date && mode && timing) {
			var code = $(thisObj).attr('data-code');
			var pdid = $(thisObj).attr('data-pdid');
			var vendor = $(thisObj).attr('data-vendor');
			return {
					'pdid' : pdid,
					'date' : date,
					'code' : code,
					'mode' : mode,
					'vendor' : vendor,
					'timing' : timing
				};
		}
		else{
			return false;
		}
	}


	{{-- make Own ActivitiesJson --}}
	function makeOwnActivitiesJson(rid) {
		var elemid = 'rid_'+rid;
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
	{{-- /make Own ActivitiesJson --}}

	function clickNextTab() {
		var ridObj = getRidObj(idObject.crid);
		$('#a_rid_'+ridObj.nrid).click();
	}


	function setCrid(rid) {
		idObject.crid = rid;
	}


	function nextHotelEvent() {
		var ridObj = getRidObj(idObject.crid);
		if (ridObj.nrid == "NaN") {
			setTimeout(function () {    
				document.location.href = "{{url('dashboard/package/builder/event/'.$package->token.'/activities')}}";
			}, 1000);
		}
		else{
			clickNextTab();
		}
	}


	{{-- addDropzone --}}
	function addDropzone(elemid) {
		Dropzone.autoDiscover = false; 	{{--keep this line if you have multiple dropzones in the same page --}}
		$(elemid).dropzone({	
			acceptedFiles: "image/*",
			url: '{{ url('image/upload') }}',
			maxFiles: 1, 	{{--Number of files at a time--}}
			maxFilesize: 2, 
			maxfilesexceeded: function(file) {
				alert('You have uploaded more than 1 Image. Only the first file will be uploaded!');
			},
			success: function (response) {
				{{--console.log(response.xhr.responseText);--}}
				var x = JSON.parse(response.xhr.responseText);
				$(this.element).attr('data-host', x.host)
													.attr('data-path', x.path)
														.removeClass('bg-color-gray');
				{{--console.log($(this.element));--}}
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
	{{-- /addDropzone --}}


	{{-- initDatePicker --}}
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
	{{-- /initDatePicker --}}

</script>