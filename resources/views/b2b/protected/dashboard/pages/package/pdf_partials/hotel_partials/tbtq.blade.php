<?php 
	$location = $hotelRoutes->location_hotel;
	$tbtqHotel = $hotel->tbtqHotel->hotel;
?>

@if (!is_null($tbtqHotel))
	<div class="{{-- height-{{ $hotelKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ ifset($tbtqHotel->HotelPicture) }}" class="img-thmb">
				<b  class="font-size-20px">{{ ifset($tbtqHotel->HotelName) }}</b>
				<span>
					{!! getStarImage($tbtqHotel->StarRating, 15, 15) !!}
				</span>
				<hr/>
				<i>
					Check In : {{ date_formatter(ifset($hotelRoutes->start_datetime->date), null,'d-M-Y') }} | 
					Check Out : {{ date_formatter(ifset($hotelRoutes->end_datetime->date), null,'d-M-Y') }}
				</i>
				<br/>
				<br/>
				<b>About Hotel : </b>
				<span>
					{!! pdfHotelDesc(ifset($tbtqHotel->HotelDescription)) !!}
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
