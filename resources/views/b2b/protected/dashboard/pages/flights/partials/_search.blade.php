<div class="row">	
	<div class="x_panel">
		{{-- <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"> --}}
		<div class="x_title">
			<h2><div class="text-center"><i class="fa fa-building"></i> Modify Search</div></h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content nopadding">

			<div class="form-group">

				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
					<input type="text" class="form-control input-airport origin" 
						id="modify_origin" placeholder="Origin" name="origin" 
						value="{{ $package->flightRoutes[0]->origin }}">
					<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback m-top-10-only">
					<input type="text" class="form-control input-airport destination" 
						id="modify_destination" placeholder="Destination" name="destination" 
						value="{{ $package->flightRoutes[0]->destination }}">
					<i class="fa fa-map-marker form-control-feedback right-1 right" aria-hidden="true"></i>
				</div>

				{{-- pax element  --}}
				{{-- @include('b2b.protected.dashboard.pages.flights.partials._pax') --}}
				{{-- /pax element  --}}
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 m-top-20">
						<button type="button" id="modify_search" class="btn btn-success btn-block btn-airport" data-rid="{{$package->flightRoutes[0]->id}}">Submit</button>
					</div>
				</div>
			</div>
		</div>
		{{-- </form> --}}
	</div>
</div>