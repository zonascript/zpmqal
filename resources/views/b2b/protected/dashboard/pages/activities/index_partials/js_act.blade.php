<script>
	function uniActivities(rid, which = 0) {
		if (rid != '') {
			var getRidObject = getRidObj(rid);
			var did =  getRidObject.did;
			var elem_id = "activities_"+rid;
			var ids = {
					'did' : did,
					'rid' : rid,
					'elem_id' : elem_id
				};

			var data = {
					"_token" : csrf_token,
				}

			var url = ''; 
			if (which == 0) {
				url = "{{ url('uni/activities/result') }}/"+did+"/sel";
			}
			else{
				url = "{{ url('uni/activities/result') }}/"+did;
			}

			$.ajax({
				type:"post",
				url: url,
				data: data,
				success: function(responce, textStatus, xhr) {
					var responce = JSON.parse(responce);
					var html = '';
					var hotels = [];

					if (responce.activities) {
						$('#loging_log').hide();

						$.each(responce.activities, function(i,v){
							console.log($('#'+elem_id).find('.'+v.code));
							var isExits = $('#'+elem_id).find('.'+v.code).length;
							console.log(isExits);
							if (isExits == 0) {
								var IsSelected = which == 0 ? 1 : 0;
								html = makeUniHtml(i, v, IsSelected, ids);
								// console.log($('#'+elem_id));
								$('#'+elem_id).append(html);
							}
						});

						/*filter.initFilter(rid);*/
						initDatePicker(rid);
					}
					else{
						$('#'+elem_id).append('<p>Activities Not Found</p>');
					}
				
					if (which == 0) { uniActivities(rid, 1); }

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
</script>


<script>
	function makeUniHtml(i, obj, selected = null, ids) {
		var isSelectedBorder = '';
		var isSelected = 0;
		var button = 'btn-primary';
		var buttonName = 'Add';
		var date = '';
		var dateStyle = 'style="display: none;"';
		var selectedMode = '';
		var selectedTiming = '';
		var description = obj.description;
		var sortDescription = shortString(description);

		if (selected == 1) {
			isSelected = 1;
			isSelectedBorder = 'border-green-3px';
			button = 'btn-danger';
			buttonName = 'Remove';
			dateStyle = '';
			date = moment(obj.date).format('DD/MM/YYYY');
			selectedMode = obj.mode;
			selectedTiming = obj.timing;
			sortDescription = shortString(description, 0, 150);
		}

		var modeOption = getModeOption(selectedMode);
		var timingOption = getTimingOption(selectedTiming);

		var activity = {
			'did' : ids.did,
			'rid' : ids.rid,
			'code' : obj.code,
			'name' : obj.name,
			'date' : date,
			'button' : button,
			'image' : obj.image,
			'vendor' : obj.vendor,
			'dateStyle' : dateStyle,
			'isSelected' : isSelected,
			'buttonName' : buttonName,
			'modeOption' : modeOption,
			'description' : description,
			'timingOption' : timingOption,
			'sortDescription' : sortDescription,
			'isSelectedBorder' : isSelectedBorder
		};

		return getActivityStack(activity);
	}
</script>

<script>
	function postSearchActivity(rid) {
		var name = $('#filter_search').val();
		var elem_id = "activities_"+rid;
		var ridObj 	=  getRidObj(rid);
		var did = ridObj.did;
		var ids = {
				'did' : did,
				'rid' : rid,
				'name' : name,
				'elem_id' : elem_id,
				'_token' : csrf_token
			};

		$.ajax({
			type:"post",
			url: "{{ url('dashboard/hotel/find/uni') }}/"+did+"",
			data: ids,
			success: function(responce, textStatus, xhr) {
				var responce = JSON.parse(responce);
				var html = '';
				var activities = responce.activities;
				$('#loging_log').hide();

				if (activities.length) {
					$.each(activities, function(i,v){
						var isExits = $('#container_'+v.code);
						if (isExits.length == 0) {
							html = makeUniHtml(i, v, null, ids);
							html = html.replace('glowing-border', 'glowing-border border-green-2px');
							$('#'+elem_id).prepend(html);
						}
						else{
							$(isExits).closest('.min-height-110px').prependTo("#"+elem_id);
						}
						initDatePicker(rid);
					});
				}
			}
		});
	}
</script>
