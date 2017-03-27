@if ($package->hotelRoutes->count())
<div class="bg-color-theme font-size-40px text-center">Hotels Details</div>
<div class="m-top-10px width-95p m-10x-auto text-justify">
	<?php $hotelKey = 0; ?>
	@foreach ($package->hotelRoutes as $hotelRoute)
		@include('b2b.protected.dashboard.pages.package.pdf_partials.hotel_partials.common')
		<?php
			// $hotel = $hotelRoutes->hotel; 
		?>

		{{-- @if ($hotel->selected_hotel_vendor == 'tbtq')
			@include('b2b.protected.dashboard.pages.package.pdf_partials.hotel_partials.tbtq')
		@elseif ($hotel->selected_hotel_vendor == 'ss')
			@include('b2b.protected.dashboard.pages.package.pdf_partials.hotel_partials.ss')
		@elseif ($hotel->selected_hotel_vendor == 'a')
			@include('b2b.protected.dashboard.pages.package.pdf_partials.hotel_partials.agoda')
		@endif --}}
		<?php $hotelKey++; ?>
	@endforeach
</div>
@endif