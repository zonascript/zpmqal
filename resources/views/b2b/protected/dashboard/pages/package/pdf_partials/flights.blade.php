@if ($package->flightRoutes->count())
<div class="m-bottom-20px{{-- min-height-1000px --}}">
	<div class="bg-color-theme font-size-40px text-center">Flights</div>
	<div class="width-95p m-10x-auto text-justify">
		@foreach ($package->flightRoutes as $flightRoutes)
			<?php 
				$flight = $flightRoutes->flight; 
			?>
			@if ($flight->selected_flight_vendor == 'qpx')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.flight_partials.qpx_flight')
			@elseif($flight->selected_flight_vendor == 'ss')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.flight_partials.ss_flight')
			@endif
		@endforeach
	</div>
</div>
@endif