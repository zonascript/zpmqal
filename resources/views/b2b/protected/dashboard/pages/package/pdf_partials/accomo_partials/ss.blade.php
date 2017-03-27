<?php 
	$location = $hotelRoutes->location_hotel;
	$skyscannerHotel = $hotel->skyscannerHotel->hotel;
?>

@if (!is_null($skyscannerHotel))
	<div class="border-gray m-top-20px">
		<table width="100%">
			<tbody>
				<tr>
					<td width="20%">
						<img src="{{ $hotel->skyscannerHotel->hotelDetail->images[0] }}" style="height: 100px; width:130px;">
					</td>
					<td width="50%">
						<div>
							<b>{{ ifset($skyscannerHotel->name) }}</b>
							<span>
								{!! getStarImage($skyscannerHotel->star_rating, 15, 15) !!}
							</span>
						</div>
						<br/>
						<div class="m-top-20px">
							<i>
								Check In : {{ date_formatter(ifset($hotelRoutes->start_datetime->date), null,'d-M-Y') }} | 
								Check Out : {{ date_formatter(ifset($hotelRoutes->end_datetime->date), null,'d-M-Y') }}
							</i>
						</div>
					</td>
					<td width="20%">
						<span>{{ echoLocation($location->country, $location->destination) }}</span>
					</td>
					<td width="10%">
						<span>{{ $hotelRoutes->nights }} Nights</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif
