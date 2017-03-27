
<?php 
	$html = 'return \'<li class="min-height-110px">
				<div class="row">
					<div id="container_\'+uniqueKey+\'" 
						class="x_panel glowing-border activityContainer \'+isSelectedBorder+\'" 
						data-activityCode="\'+uniqueKey+\'" 
						data-index="\'+i+\'" 
						data-did="\'+ids.did+\'" 
						data-rid="\'+ids.rid+\'" 
						data-vendor="\'+vendor+\'"
						>
						<div class="col-md-10 col-sm-10 col-xs-12">
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class="row">
										<div class="row height-165px">
											<img src="\'+image+\'" alt="" height="100%" width="100%">
										</div>
									</div>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2 class="search-word">\'+name+\'</h2>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<span id="activitySortDescription_\'+uniqueKey+\'">
											\'+sortDescription+\'
										</span>
										<button id="btn-descriptionMore_\'+uniqueKey+\'" 
											class="btn-link cursor-pointer nopadding" 
											data-toggle="modal" 
											data-target=".bs-example-modal-lg" 
											data-title="\'+name+\' : Description" 
											data-bodyid="activityFullDescription_\'+uniqueKey+\'" 
											data-button="false" 
											data-index="\'+uniqueKey+\'">More
										</button>
										<div id="activityFullDescription_\'+uniqueKey+\'" hidden>
											\'+description+\'
										</div>
									</div>
									<div id="inputContainer_\'+uniqueKey+\'" \'+dateStyle+\'>
										<div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
													<input type="text" placeholder="Date" value="\'+date+\'" name="ActivityDate"
														class="form-control has-feedback-left 
																datepicker datepicker-\'+ids.rid+\' p-left-10" 
														aria-describedby="inputSuccess2Status3"
													/>
													<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
												</div>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
													<select class="btn-block height-34 border-gray padding-5 act-timing">
														\'+timingOption+\'
													</select>
												</div>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
													<select class="btn-block height-34 border-gray padding-5 mode">
														\'+modeOption+\'
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-12">
							<div class="height-150px vertical-parent">
								<div class="vertical-child">
									<div class="m-top-30">
										<button 
											class="btn \'+button+\' btn-block btn-activitySelect" 
											data-index="\'+i+\'"
											data-uniqueid="\'+uniqueKey+\'" 
											data-selected="\'+isSelected+\'"
											data-did="\'+ids.did+\'"
											data-rid="\'+ids.rid+\'"
											>\'+buttonName+\'
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>\'';

	$html = trim( preg_replace('/\s+/', ' ', preg_replace('/\t+/', '',$html)));
?>
<script>
	function uniActivities(did, rid) {
		if (did != '') {
			var elem_id = "activities_"+rid;
			var ids = {
					'did' : did,
					'rid' : rid,
					'elem_id' : elem_id
				};

			var data = {
					"_token" : "{{ csrf_token() }}",
				}

			$.ajax({
				type:"post",
				url: "{{ url('uni/activities/result') }}/"+did,
				data: data,
				success: function(responce, textStatus, xhr) {
					var responce = JSON.parse(responce);
					// console.log(responce);
					var html = '';
					var hotels = [];

					if (responce.activities) {
						$('#loging_log').hide();

						$.each(responce.activities, function(i,v){
							html = makeUniHtml(i,v,responce, ids);
							$('#'+elem_id).append(html);
						});

						filter.initFilter(rid);
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
						$('#'+elem_id).html('<div id="sorry_error" class="m-top-20"><h1>Sorry Something went wrong<h1><div class="row"><div class="col-md-6 col-sm-6 col-xs-12 offset-col-md-3"><button class="btn btn-primary btn-block" onclick="'+uniActivities(did, rid)+';">Refreash</button></div></div></div>');
					}
				}
			});
		}
	}
</script>






<script>
	function makeUniHtml(i, obj,responce, ids) {
		<?php 
			$datesObj = [];
			foreach ($package->hotelRoutes as $hotelRoute) {
				$minDate = date_differences($hotelRoute->start_date,date("Y-m-d"));
				$maxDate = date_differences($hotelRoute->end_date,date("Y-m-d"));

				$datesObj["rid_".$hotelRoute->id] = [
						'startDate' => date_formatter($hotelRoute->start_date, 'Y-m-d H:i:s', 'd-m-Y'),
						'endDate' => date_formatter($hotelRoute->end_date, 'Y-m-d H:i:s', 'd-m-Y'),
						'minDate' => $minDate,
						'maxDate' => $maxDate
					];
			}
		?>

		var dateObj = {!! json_encode($datesObj) !!}
		var isSelectedBorder = '';
		var isSelected = 0;
		var button = 'btn-primary';
		var buttonName = 'Add';
		var date = '';
		var dateStyle = 'style="display: none;"';
		var startDate = dateObj["rid_"+ids.rid].startDate;
		var minDate = dateObj["rid_"+ids.rid].minDate;
		var maxDate = dateObj["rid_"+ids.rid].maxDate;
		var name = obj.name;
		var image = obj.image;
		var vendor = obj.vendor;
		var uniqueKey = obj.code;
		var currency = obj.currency;
		var description = obj.description;
		var sortDescription = '';
		if (description !=  null) {
			sortDescription = description.substring(0, 350);
		}
		var selectedMode = '';
		var selectedTiming = '';
		var modeOption = '';
		var timingOption = '';
		var modeObj = {
						'Mode' : '',
						'No Transfer' : 'no', 
						'Private' : 'private',
						'SIC' :  'sic', 
						'Self Drive' : 'selfdrive'
					};

		var timingObj = {
						'Timing' : '',
						'Morning' : 'morning', 
						'Noon' : 'noon',
						'Evening' :  'evening', 
						'Half Day' : 'halfday',
						'Full Day' : 'fullday'
					};


		if (responce.selected != null && responce.selected.hasOwnProperty(uniqueKey)) {
			isSelected = 1;
			isSelectedBorder = 'border-green-3px';
			button = 'btn-danger';
			buttonName = 'Remove';
			dateStyle = '';
			date = responce.selected[uniqueKey].date;
			selectedMode = responce.selected[uniqueKey].mode;
			selectedTiming = responce.selected[uniqueKey].timing;
			if (description !=  null) {
				sortDescription = description.substring(0, 150);
			}
		}

		$.each(modeObj, function(mI,mV){
			var isSelectedWord = '';
			if (mV == selectedMode) {
				isSelectedWord = 'selected';
			}
			modeOption += '<option value="'+mV+'" '+isSelectedWord+'>'+mI+'</option>';
		});

		$.each(timingObj, function(mI,mV){
			var isSelectedWord = '';
			
			if (mV == selectedTiming) {
				isSelectedWord = 'selected';
				console.log(mI+' ' + mV+' '+isSelectedWord)
			}

			timingOption += '<option value="'+mV+'" '+isSelectedWord+'>'+mI+'</option>';
		});

		<?php echo $html; ?>
	}
</script>