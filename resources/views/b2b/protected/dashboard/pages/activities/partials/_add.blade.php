<li id="own_activity_'+uniqueId+'" class="min-height-110px ">
	<div class="row">
		<div
			class="x_panel glowing-border border-blue-1px activity-container isSelectedBorder" 
			data-did="'+did+'" data-rid="'+rid+'" data-vendor="own">
			<div class="col-md-10 col-sm-10 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="row">
							<div class="row">
								<form id="uploadform_'+uniqueId+'" class="uploadform dropzone no-margin nopadding dz-clickable min-max-height-170px bg-color-gray" data-path="" data-host="">	
									{{ csrf_field() }}
									<div class="dz-default dz-message">
										<div class="row">
											<div class="col-md-8 col-sm-8 col-xs-8 col-md-offset-2">
												<div class="height-100px vertical-parent">
													<div class="vertical-child">
														Drop activity image here
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<input type="text" class="form-control width-100-p activity-name" placeholder="Activity Title...">
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<textarea class="form-control width-100-p m-top-10 min-height-125px activity-description" placeholder="Activity Description..."></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-2 col-xs-12">
				<div class="row">
					<div class="row">
						<div class="form-group has-feedback">
							<input type="text" placeholder="Date" name="ActivityDate"
								class="form-control has-feedback-left 
										datepicker datepicker-'+rid+' p-left-10" 
								aria-describedby="inputSuccess2Status3"
							/>
							<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
					</div>
					<div class="row">
						<select class="btn-block height-34 border-gray padding-5 timing">
							<option value="">Timing</option>
							<option value="morning">Morning</option>
							<option value="noon">Noon</option>
							<option value="evening">Evening</option>
							<option value="halfday">Half Day</option>
							<option value="fullday">Full Day</option>
						</select>
					</div>
					<div class="row m-top-10">
						<select class="btn-block height-34 border-gray padding-5 mode">
							<option value="">Mode</option>
							<option value="no">No Transfer</option>
							<option value="private">Private</option>
							<option value="sic">SIC</option>
							<option value="selfdrive">Self Drive</option>
						</select>
					</div>
					<div class="row m-top-10">
						<button class="btn btn-danger btn-block btn-remove-own" 
							data-count="'+count+'" data-uid="'+uniqueId+'" data-toggle="modal" 
							data-target=".bs-example-modal-confirm">
							Remove
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>