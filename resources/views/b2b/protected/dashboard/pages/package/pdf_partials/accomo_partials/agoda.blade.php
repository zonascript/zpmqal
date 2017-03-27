@if (!is_null($hotel->agodaHotel))
	<?php 
		$agodaHotel = $hotel->agodaHotel;
		$image = $agodaHotel->photo1;
		$hotelName = $agodaHotel->hotel_name;
		$starRating = getStarImage($agodaHotel->star_rating, 15, 15);
		$location = $hotelRoutes->destination_detail->location;
		$startDate = $hotelRoutes->start_datetime->format('d-M-Y');
		$endDate = $hotelRoutes->end_datetime->format('d-M-Y');
	?>
	<div class="border-gray m-top-20px">
		<table width="100%">
			<tbody>
				<tr>
					<td width="20%">
						<img src="{{ $image }}" style="height: 100px; width:130px;">
					</td>
					<td width="70%">
						<div>
							<b>{{ $hotelName }}</b>
							<span>{!! $starRating !!}</span>
						</div>
						<div class="m-top-5px"><b>Location: </b>{{ $location }}</div>
						<div class="m-top-20px">
							<i>Check In : {{ $startDate }} | Check Out : {{ $endDate }}</i>
						</div>
					</td>
					<td width="10%">
						<span>{{ $hotelRoutes->nights }} Nights</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif
