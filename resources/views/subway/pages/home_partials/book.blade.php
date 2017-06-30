<div class="book-popup popup-model" style="display: none;">
	<div class="middle mod-box-color4">
		<button type="button" class="close book-popup" data-dismiss="modal" aria-label="Close"><span class="font-size-35" aria-hidden="true">×</span></button>
		<div class="row"></div>
		{{-- <div class="bg-color-black-trans padding-5 text-center">
			<h1>Book Now</h1>
		</div> --}}
		<div class="m-top-10"></div>
		<h2>
			<div class="row text-center">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<label>
						<input type="radio" class="radio-md book" value="pay_now" name="book" checked="">Pay now
					</label>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<label>
						<input type="radio" class="radio-md book" value="reserve" name="book">Reserve
					</label>
				</div>
			</div>
		</h2>
		<div class="m-top-30"></div>

		<form id="form_pay_now" data-parsley-validate="" class="form-horizontal form-label-left white" novalidate="">
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">First Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Last Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="date-of-departure">Date of Departure <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="date-of-departure" required="required" class="form-control col-md-7 col-xs-12 datepicker noradius">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="pax">Total Pax <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="pax" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
		
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="amount">Amount <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="amount" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			

			{{-- <div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12">Description</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea name="" id="" style="margin: 0px; width: 312px; height: 90px;"></textarea>
				</div>
			</div> --}}

		 	<div class="down-div">
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
						<button type="submit" class="btn btn-default">Book Now</button>
					</div>
				</div>
		 	</div>
		</form>
		<form id="form_reserve" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="" style="display: none;">
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">First Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Last Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="date-of-departure">Date of Departure <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="date-of-departure" required="required" class="form-control col-md-7 col-xs-12 datepicker noradius">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12" for="pax">Total Pax <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="last-name" name="pax" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			</div>

			{{-- <div class="form-group">
				<label class="control-label col-md-4 col-sm-4 col-xs-12">Description</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<textarea name="" id="" style="margin: 0px; width: 312px; height: 130px;"></textarea>
				</div>
			</div> --}}
		 	<div class="down-div">
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-1">
						<button type="submit" class="btn btn-default">Reserve</button>
					</div>
				</div>
		 	</div>
		</form>
	</div>
</div>