<?php 
	$location = $hotelRoutes->location_hotel;
	$skyscannerHotel = $hotel->skyscannerHotel->hotel;
?>

@if (!is_null($skyscannerHotel))
	<div class="{{-- height-{{ $hotelKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ $hotel->skyscannerHotel->hotelDetail->images[0] }}" class="img-thmb">
				<b  class="font-size-20px">{{ $skyscannerHotel->name }}</b>
				<span>
					{!! getStarImage($skyscannerHotel->star_rating, 15, 15) !!}
				</span>
				<hr/>
				<i>
					Check In : {{ date_formatter($hotelRoutes->start_datetime->date, null,'d-M-Y') }} | 
					Check Out : {{ date_formatter($hotelRoutes->end_datetime->date, null,'d-M-Y') }}
				</i>
				<br/>
				<br/>
				<b>About Hotel : </b>
				<span>
					{!! pdfHotelDesc($hotel->skyscannerHotel->hotelDetail->result->hotels[0]->description) !!}
				</span>
				{{-- <hr/> --}}
			</div>
			{{-- <div>
				<h4 class="h-num">Hotel Facilities</h4>
				<span>
				 {{ implode(' | ', ifset($tbtqHotel->Facilities)) }}
				</span>
			</div>
			<hr/>
			<div>
				<h4 class="h-num">Hotel Attractions</h4>
				<span>
					{{ implode(' | ', ifset($tbtqHotel->Attractions)) }}
				</span>
			</div> --}}
		</div>       
	</div>
	@if ($hotelRoutes->count()-1 != $hotelKey)
		<hr {{-- class="hr-gold" --}}>
	@endif
@endif
