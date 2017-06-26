@extends('backend.protected.dashboard.main')
@section('content')
	<div class="row top_tiles">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="tile-stats">
						<a href="{{ url('dashboard/manage/location/country') }}">
							<div class="height-200px font-size-30 vertical-parent">
								<div class="vertical-child">
									<i class="fa fa-map-marker font-size-80"></i>
									<div>Country Images</div>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="tile-stats">
						<a href="{{ url('dashboard/manage/location/destination') }}">
							<div class="height-200px font-size-30 vertical-parent">
								<div class="vertical-child">
									<i class="fa fa-map-marker font-size-80"></i>
									<div>Destination Images</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection