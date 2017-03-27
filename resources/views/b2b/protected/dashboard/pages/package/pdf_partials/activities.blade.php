@if ($package->hotelRoutes->count())
<div class="bg-color-theme font-size-40px text-center">Inclusion</div>
<div class="width-95p m-10x-auto">
	@foreach ($package->hotelRoutes as $hotelRoute)
		<?php 
			$activities = isset($hotelRoute->activities->activities_detail) 
									? $hotelRoute->activities->activities_detail 
									: [];
									
			$location = $hotelRoute->location_hotel;
		?>
		@foreach ($activities as $activity)
			@include('b2b.protected.dashboard.pages.package.pdf_partials.activities_partials.union')
		@endforeach
	@endforeach
</div>
@endif
