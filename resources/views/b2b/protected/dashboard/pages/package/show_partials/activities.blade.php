@if ($package->hotelRoutes->count())
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12">
					<h1>Activities List</h1>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 m-top-10">
					<a href="{{ urlActivitiesBuilder($package->id) }}" class="btn btn-success btn-block">Modify All Activities</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			@foreach ($package->hotelRoutes as $hotelRoute)
				<?php
					// dd($hotelRoute->packageActivities[0]->activityObject());
					$location = $hotelRoute->destination_detail;
					$selectedActivities = $hotelRoute->packageActivities;
				?>
				@if ($hotelRoute->packageActivities->count())
				<div class="row">
					<div class="x_panel">
						<div class="x_title">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h2><b>{{ $location->echo_location }}</b></h2>
							</div>
							<div class="col-md-5 col-sm-5 col-xs-12">
								<h2 class="pull-right">
									({{ $hotelRoute->start_datetime->format('d-M-Y') }}
										To
									{{ $hotelRoute->end_datetime->format('d-M-Y')}})
								</h2>
							</div>
							<div class="col-md-1 col-sm-1 col-xs-12">
								<ul class="nav navbar-right panel_toolbox panel_toolbox1">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
								</ul>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<div class="row">
								<ul class="list list-unstyled">
									@foreach ($selectedActivities as $selectedActivity)
										@include($viewPath.'.show_partials.activities_partials.index')
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
				@endif
			@endforeach
		</div>
	</div>
</div>
@endif
