{{-- Hotel Serach --}}
<div class="col-md-3 col-md-3 col-xs-12">
	<div class="row">	
		<div class="x_panel">
			<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
				<div class="x_title">
					<h2><div class="text-center"><i class="fa fa-building"></i> Hotel Search</div></h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content nopadding">
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control" id="inputSuccess3" placeholder="Select City, Area..">
							<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control has-feedback-left datepicker p-left-10" id="checkinDate" placeholder="Check In" aria-describedby="inputSuccess2Status3">
							<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
							<input type="text" class="form-control has-feedback-left datepicker p-left-10" id="checkoutDate" placeholder="Check Out" aria-describedby="inputSuccess2Status3">
							<i class="fa fa-calendar form-control-feedback right-1 right" aria-hidden="true"></i>
						</div>

						{{-- Rooms-element  --}}
						<div id="room">
							@for ($room = 1; $room <= 8 ; $room++)
								{{-- expr --}}
							<div id="room_{{ ($room+1)/2 }}" {{ $room != 1 ? 'hidden' : '' }}>
								{{-- Adult Button --}}
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-10-only form-group has-feedback">
								<label for="">Room : {{ ($room+1)/2 }}</label>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 m-top-10-only  form-group has-feedback">
									<div class="center">
										<div class="input-group">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_{{ $room }}" data-name="adult">
													<span class="glyphicon glyphicon-minus"></span>
												</button>
											</span>
											<span class="form-control text-center nopadding-right">
												<span id="a_value">
													<input type="text" name="quant_{{ $room }}" class="width-10 nostyle input-number" value="1" min="1" max="4" disabled="disabled">
												</span>
												<span id="a_word" name="quant_{{ $room }}">Adult</span>
											</span>
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_{{ $room }}" data-name="adult">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</span>
										</div>
									</div>
								</div>
								{{-- /Adult Button --}}
								<?php $room++ ?>
								{{-- Child Button --}}
								<div class="col-md-12 col-sm-12 col-xs-12 nopadding form-group has-feedback">
									<div class="center">
										<div class="input-group">
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-number noradius bg-color-gray" disabled="disabled" data-type="minus" data-field="quant_{{ $room }}" data-name="child">
													<span class="glyphicon glyphicon-minus"></span>
												</button>
											</span>
											<span class="form-control text-center nopadding-right">
												<span id="a_value">
													<input type="text" name="quant_{{ $room }}" class="width-10 nostyle input-number" value="0" min="0" max="2" disabled="disabled">
												</span>
												<span id="c_word" name="quant_{{ $room }}">Child</span>
											</span>
											<span class="input-group-btn">
												<button type="button" class="btn btn-default btn-number noradius bg-color-gray m-right-0" data-type="plus" data-field="quant_{{ $room }}" data-name="child">
													<span class="glyphicon glyphicon-plus"></span>
												</button>
											</span>
										</div>
									</div>
								</div>
								{{-- /Child Button --}}

								{{-- Age html --}}
								<div class="age" data-age="quant_{{ $room }}"></div>
								{{-- /age html --}}

							</div>
							
							@endfor
						</div>
						{{-- /Rooms-element  --}}
						{{-- Add Room button --}}
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10-only">
							<div >
								<a id="btn-addRoom" class="btn-link cursor-pointer">Add Room</a>
								<span id="pipeSapr" hidden> | </span>
								<a id="btn-removeRoom" class="btn-link cursor-pointer" hidden>Remove Room</a>
							</div>
						</div>
						{{-- /Add Room button --}}

						{{-- Star Rating button --}}
						<div class="col-md-12 col-sm-12 col-xs-12 m-top-10-only ">
							
							@for ($rating = 1; $rating <= 5 ; $rating++)
								<div class= "col-xs-15 col-sm-15 col-md-15 col-lg-15 nopadding">
									<div class="btn btn-default btn-block btn-starRating noradius">
										<div>{{ $rating }}</div>
										<i class="fa-star fa span-starRatting {{ $rating > 2 ? 'font-gold' : '' }}" data-rating="{{ $rating }}" data-status=""></i>
									</div>
								</div>
							@endfor

						</div>
						{{-- /Star Rating button --}}

					</div>
					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12 nopadding">
							<button type="submit" class="btn btn-success btn-block">Submit</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
{{-- /Hotel Serach --}}