@if (!is_null($hotel->agodaHotel))
	<?php 
		$agodaHotel = $hotel->agodaHotel;
		$image = $agodaHotel->photo1;
		$hotelName = $agodaHotel->hotel_name;
		$description = $agodaHotel->overview;
		$starRating = getStarImage($agodaHotel->star_rating, 15, 15);
		$location = $hotelRoutes->destination_detail->location;
		$startDate = date_formatter(ifset($hotelRoutes->start_datetime->date), null,'d-M-Y');
		$endDate = date_formatter(ifset($hotelRoutes->end_datetime->date), null,'d-M-Y');
	?>
	<div class="{{-- height-{{ $hotelKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ $image }}" class="img-thmb">
				<b  class="font-size-20px">{{ $hotelName }}</b>
				<span>
					{!! $starRating !!}
				</span>
				<hr/>
				<i>Check In : {{ $startDate }} | Check Out : {{ $endDate }}</i>
				<br/>
				<span><b>Location: </b>{{ $location }}</span>
				<br/><br/>
				<b>About Hotel : </b>
				<span>{!! $description !!}</span>
			</div>
		</div>       
	</div>
	@if ($hotelRoutes->count()-1 != $hotelKey)
		<hr {{-- class="hr-gold" --}}>
	@endif
@endif
