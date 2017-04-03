<div class="x_panel">
	<div class="x_title">
		<h2>
			Grand Total
		</h2>
		<ul class="nav navbar-right panel_toolbox panel_toolbox1">
			<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
	<div class="x_content">
		{{-- Grand Total Left Side --}}
		<div class="col-md-12 col-sm-12 col-xs-12">
			
			{{-- Hotel Cost --}}
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12 font-size-15 m-top-5">
					<label for=""> Net Cost : </label>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="netCost" class="inputCalc form-control has-feedback-left p-left-10" placeholder="want to enter Manually" aria-describedby="inputSuccess2Status3" name="TotalHotelsCost" value="{{ isset($package->cost->net_cost) ? $package->cost->net_cost : 0 }}">
					<i class="fa fa-home form-control-feedback right" aria-hidden="true"></i>
				</div>
			</div>

			<div class="row m-top-10">
				<div class="col-md-6 col-sm-6 col-xs-12 font-size-15 m-top-5">
					<label for=""> Profit/Margin Cost : </label>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<input type="text" id="profitCost" class="inputCalc form-control has-feedback-left p-left-10" placeholder="want to enter Manually" aria-describedby="inputSuccess2Status3" name="TotalHotelsCost" value="{{ isset($package->cost->margin) ? $package->cost->margin : 0 }}">
					<i class="fa fa-home form-control-feedback right" aria-hidden="true"></i>
				</div>
			</div>

			<div class="row m-top-20">
				<div class="col-md-5 col-sm-5 col-xs-12">
					<button type="button" id="btnSaveCost" class="btn btn-success btn-block">Save Cost</button>
				</div>
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="text-right">
						<h2>
							<span>Total Cost : </span>
							<i class="fa fa-rupee"></i> 
							<span id="totalCost" data-ischanged="0">
								{{ $package->cost->totalCost }}.00
							</span>
						</h2>
					</div>
				</div>
			</div>

			<div class="row m-top-20">
				<div class="col-md-5 col-sm-5 col-xs-12">
					<button id="run_pdf" class="btn btn-primary btn-block" target="_blank">Generate PDF</button>
					<a id="btn_pdf" href="{{ newRedirectUrl(urlPdfPacakge($package->id)) }}" class="btn btn-primary btn-block hide" target="_blank"></a>
				</div>
			</div>
			<div class="row m-top-20">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<input class="btn-block" id="show_html_link" type="text">
				</div>
			</div>
		</div>
		{{-- /Grand Total Left Side --}}
	</div>
</div>