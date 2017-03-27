{{-- Hotel Serach --}}
<div class="col-md-3 col-md-3 col-xs-12">
	<div class="row">	
		<div class="x_panel">
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
				<div class="x_title">
					<h2><div class="text-center"><i class="fa fa-building"></i> Flight Search</div></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content nopadding">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control input-airport origin" id="inputSuccess3" placeholder="Origin" name="origin">
							<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control input-airport destination" id="inputSuccess3" placeholder="Destination" name="destination">
							<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival" placeholder="Arrival" aria-describedby="inputSuccess2Status3" name="arrival">
							<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>

						{{-- Rooms-element  --}}
						<div id="pax">
							{{-- Adult Button --}}
							<div class="col-md-12 col-sm-12 col-xs-12 m-top-10-only form-group has-feedback">
								<div class="center">
									<div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_1" data-name="adult">
												<span class="glyphicon glyphicon-minus"></span>
											</button>
										</span>
										<span class="form-control text-center nopadding-right">
											<span id="a_value">
												<input type="text" name="quant_1" class="width-15 adult nostyle input-number" value="1" min="1" max="10" disabled="disabled">
											</span>
											<span id="a_word" name="quant_1">Adult <small>(12+ yrs)</small></span>
										</span>
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_1" data-name="adult">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
										</span>
									</div>
								</div>
							</div>
							{{-- /Adult Button --}}
							
							{{-- Child Button --}}
							<div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group has-feedback">
								<div class="center">
									<div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_2" data-name="child">
												<span class="glyphicon glyphicon-minus"></span>
											</button>
										</span>
										<span class="form-control text-center nopadding-right">
											<span id="a_value">
												<input type="text" name="quant_2" class="width-15 nostyle input-number child" value="0" min="0" max="12" disabled="disabled">
											</span>
											<span id="c_word" name="quant_2">Child <small>(2-12 yrs)</small></span>
										</span>
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_2" data-name="child">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
										</span>
									</div>
								</div>
							</div>
							{{-- /Child Button --}}

							{{-- infant Button --}}
							<div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group has-feedback">
								<div class="center">
									<div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_3" data-name="infant">
												<span class="glyphicon glyphicon-minus"></span>
											</button>
										</span>
										<span class="form-control text-center nopadding-right">
											<span id="a_value">
												<input type="text" name="quant_3" class="width-15 nostyle input-number infant" value="0" min="0" max="12" disabled="disabled">
											</span>
											<span id="c_word" name="quant_3">Infant<small> (below 2 yrs)</small></span>
										</span>
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_3" data-name="infant">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
										</span>
									</div>
								</div>
							</div>
							{{-- /infant Button --}}

						</div>
						{{-- /Rooms-element  --}}
					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
							<button type="button" class="btn btn-success btn-block btn-airport">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- /Hotel Serach --}}