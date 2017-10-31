<div id="destination1" class="col-md-12 col-sm-12 col-xs-12 form-group-self destinationList no-rid" data-destination="1" data-rid="" data-order="">
	<div class="col-md-2 col-sm-2 col-xs-12">
		<select class="form-control nopadding p-left-10 mode inctv" required="" data-parsley-type="value">
			<option value="" selected="">Select Mode</option>
			{!! $indication->htmlOptions('route_mode') !!}
		</select>
	</div>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<div class="row location-input-div"></div>
	</div>
	<div class="col-md-1 col-sm-1 col-xs-12 text-center">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6 text-center">
				<a class="rmv-destlist cursor-pointer">
					<i class="fa fa-times-circle font-size-30 m-top-2"></i>
				</a>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6 text-center">
				<a class="btn-add-route green cursor-pointer">
					<i class="fa fa-plus-square font-size-30 m-top-2"></i>
				</a>
			</div>
		</div>
	</div>
</div>