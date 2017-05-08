<li class="min-height-110px activity-container li_'+activity.ukey+'">
	<div class="row">
		<div class="x_panel glowing-border '+activity.border+'">
			<div class="col-md-10 col-sm-10 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<div class="row height-165px">
								<img src="'+activity.image+'" alt="" height="100%" width="100%">
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h2 class="search-word">'+activity.name+'</h2>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<span class="sort-description">
								'+activity.sortDescription+'
							</span>
							<button
								class="btn-link cursor-pointer nopadding btn-description" 
								data-title="'+activity.name+' : Description" 
								data-target="#full_description_'+activity.ukey+'">More
							</button>
							<div id="full_description_'+activity.ukey+'" 
								class="full-description" hidden>'+activity.description+'
							</div>
						</div>
						<div class="input-container" '+activity.dateStyle+'>
							<div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
										<input type="text" placeholder="Date" 
											value="'+activity.date+'" name="ActivityDate"
											class="form-control has-feedback-left 
													datepicker datepicker-'+activity.rid+' p-left-10 p-right-0" 
											aria-describedby="inputSuccess2Status3"
										/>
										<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
										<select class="btn-block height-34 border-gray padding-5 act-timing">
											'+activity.timingOption+'
										</select>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
										<select class="btn-block height-34 border-gray padding-5 mode">
											'+activity.modeOption+'
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
								class="btn '+activity.btnClass+' btn-block btn-activitySelect"
								data-pdid="'+activity.pdid+'"
								data-code="'+activity.code+'" 
								data-vendor="'+activity.vendor+'"
								>'+activity.btnName+'
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>