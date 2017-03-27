<!-- foreach ever destination activity here -->
<div class="row">
	<div class="x_panel">
		<div class="x_title">
			<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
				<h2><b>Auckland</b> (Activities)</h2>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<h2 class="pull-right">( 03-Nov-2016 To 09-Nov-2016 )</h2>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-12 nopadding">
				<ul class="nav navbar-right panel_toolbox panel_toolbox1">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
				<ul class="list list-unstyled">
					
					{{-- foreach every activity here --}}
					<li class="min-height-110px">
						<div class="x_panel glowing-border nopadding border-green-3px">
							<div class="col-md-10 col-sm-10 col-xs-12 nopadding">
								<div class="col-md-3 col-sm-3 col-xs-12">
									<div class="row height-160px">
										<img src="{{ url('images/default_hotel.png') }}" alt="" height="100%" width="100%">
									</div>
								</div>
								<div class="col-md-9 col-sm-9 col-xs-12">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<h2>Agroventures Adventure Park - Family Ride Packages</h2>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veniam harum aspernatur perspiciatis...<a href="">More</a>
									</div>
									<div>
										{{-- Date --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
												<input type="text" class="form-control has-feedback-left datepicker p-left-10 arrival" placeholder="Date" aria-describedby="inputSuccess2Status3" name="arrival">
												<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
											</div>
										</div>
										{{-- /Date --}}

										{{-- Adult Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
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
															<span id="a_word" name="quant_1">Adult</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_1" data-name="adult">
																<span class="glyphicon glyphicon-plus"></span>
															</button>
														</span>
													</div>
												</div>
											</div>
										</div>
										{{-- /Adult Button --}}
										
										{{-- Child Button --}}
										<div class="col-md-4 col-sm-4 col-xs-12">
											<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
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
															<span id="c_word" name="quant_2">Child</span>
														</span>
														<span class="input-group-btn">
															<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_2" data-name="child">
																<span class="glyphicon glyphicon-plus"></span>
															</button>
														</span>
													</div>
												</div>
											</div>
										</div>
										{{-- /Child Button --}}
									</div>

									{{-- if sic and private exist --}}
										<div>
											{{-- Date --}}
											<div class="col-md-4 col-sm-4 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback nopadding">
													<select name="" id="" class="form-control has-feedback p-left-10 arrival">
														<option value="">Select Type?</option>
														<option value="sic">Sic</option>
														<option value="private">Private</option>
													</select>
												</div>
											</div>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback nopadding">
													<select name="" id="" class="form-control has-feedback p-left-10 arrival">
														<option value="">Select Car</option>
														<option value="sic">Honda City - 4 Seater</option>
														<option value="sic">Innova - 7 Seater</option>
														<option value="sic">2 X Honda City - 4 Seater</option>
													</select>
												</div>
											</div>
											{{-- /Date --}}
										</div>
									{{-- /if sic and private exist --}}
								</div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12">
								<div class="height-150px vertical-parent">
									<div class="vertical-child">
										<h2 class="flightPrice">Rs. 13033/-</h2>
										<div class="m-top-30">
											<button class="btn btn-primary btn-block">Select</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					{{-- /foreach every activity here --}}

				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /foreach ever destination activity here -->

