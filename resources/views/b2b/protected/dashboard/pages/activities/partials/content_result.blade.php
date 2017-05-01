{{-- foreach ever destination activity here --}}

@forelse ($activitiesSlices as $activitiesSlice_key => $activitiesSlice)
<div class="row">
	<div class="x_panel">
		<div class="x_title">
			<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
				<?php 
					$startDate = $activitiesSlice->model->start_date;
					$endDate = $activitiesSlice->model->end_date;
				?>
				<h2><b>{{ $activitiesSlice->location->country.'-'.$activitiesSlice->location->destination }}</b> (Activities)</h2>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<h2 class="pull-right">
					({{ date_formatter($startDate,'Y-m-d', 'd-M-Y') }}
						To
					{{ date_formatter($endDate,'Y-m-d', 'd-M-Y') }})
				</h2>
			</div>
			<div class="col-md-1 col-sm-1 col-xs-12 nopadding">
				<ul class="nav navbar-right panel_toolbox panel_toolbox1">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content max-height-75vh scroll-auto">
			<div class="col-md-12 col-sm-12 col-xs-12">
				@include('b2b.protected.dashboard.pages.activities.partials.content_result_fgf')
				@include('b2b.protected.dashboard.pages.activities.partials.content_result_viator')
			</div>
		</div>
	</div>
</div>
@empty
<h1>There is no activity</h1>
@endforelse

{{-- /foreach ever destination activity here --}}

