@if ($package->hotelRoutes->count())
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<div class="row">
				<div class="col-md-7 col-sm-7 col-xs-12">
					<h1>Hotel List</h1>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12 m-top-10">
					<a href="{{ urlAllHotelsBuilder($package->id) }}" class="btn btn-success btn-block">Modify Hotels</a>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-12 m-top-10">
					<ul class="nav navbar-right panel_toolbox panel_toolbox1">
						<li><a class="collapse-link"><i class="fa fa-chevron-up font-size-30"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			@foreach ($package->hotelRoutes as $hotelRoute)
				@if ($hotelRoute->hotel->selected_hotel_vendor == 'tbtq')
					@include('b2b.protected.dashboard.pages.package.show_partials.hotel_partials.tbtq')
				@elseif($hotelRoute->hotel->selected_hotel_vendor == 'ss')
					@include('b2b.protected.dashboard.pages.package.show_partials.hotel_partials.ss')
				@elseif($hotelRoute->hotel->selected_hotel_vendor == 'a')
					@include('b2b.protected.dashboard.pages.package.show_partials.hotel_partials.agoda')
				@endif
			@endforeach
		</div>
	</div>
</div>
@endif