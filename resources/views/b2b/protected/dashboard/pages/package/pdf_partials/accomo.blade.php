@if ($package->hotelRoutes->count())
<div class="m-bottom-20px">
	<div class="bg-color-theme font-size-40px text-center">Accommodation</div>
	<div class="width-95p m-10x-auto text-justify">
		<?php $hotelKey = 0; ?>
		@foreach ($package->hotelRoutes as $hotelRoute)
			@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo_partials.common')
			
			<?php 
				// $hotel = $hotelRoutes->hotel_accomo; 
				// dd($hotel);
			?>

			{{-- @if ($hotel->selected_hotel_vendor == 'tbtq')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo_partials.tbtq')
			@elseif ($hotel->selected_hotel_vendor == 'ss')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo_partials.ss')
			@elseif ($hotel->selected_hotel_vendor == 'a')
				@include('b2b.protected.dashboard.pages.package.pdf_partials.accomo_partials.agoda')
			@endif --}}
			<?php $hotelKey++; ?>
		@endforeach
	</div>
</div>
@endif