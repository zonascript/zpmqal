@if (!is_null($hotelRoute->hotel_detail))
	<div class="border-gray m-top-20px">
		<table width="100%">
			<tbody>
				<tr>
					<td width="20%">
						<img src="{{ $hotelRoute->hotel_detail->image }}" style="height: 100px; width:130px;">
					</td>
					<td width="70%">
						<div>
							<b>{{ $hotelRoute->hotel_detail->name }}</b>
							<span>{!! $hotelRoute->hotel_detail->starRating !!}</span>
						</div>
						<div class="m-top-5px">
							<b>Location: </b>
							<span>{{ $hotelRoute->hotel_detail->location }}</span>
						</div>
						<div class="m-top-20px">
							<i>Check In : {{ $hotelRoute->hotel_detail->startDate }} | Check Out : {{ $hotelRoute->hotel_detail->endDate }}</i>
						</div>
					</td>
					<td width="10%">
						<span>{{ $hotelRoute->hotel_detail->nights }} Nights</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
@endif
