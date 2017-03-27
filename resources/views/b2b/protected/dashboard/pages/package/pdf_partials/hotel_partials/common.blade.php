@if (!is_null($hotelRoute->hotel_detail))
	<div class="{{-- height-{{ $hotelKey == 0 ? 980 : 1000 }} px --}} p-5">
		<div>
			<div class="box-stack">
				<img src="{{ $hotelRoute->hotel_detail->image }}" class="img-thmb">
				<b  class="font-size-20px">{{ $hotelRoute->hotel_detail->name }}</b>
				<span>
					{!! $hotelRoute->hotel_detail->starRating !!}
				</span>
				<hr/>
				<i>Check In : {{ $hotelRoute->hotel_detail->startDate }} | Check Out : {{ $hotelRoute->hotel_detail->endDate }}</i>
				<br/>
				<span><b>Location: </b>{{ $hotelRoute->hotel_detail->location }}</span>
				<br/><br/>
				<b>About Hotel : </b>
				<span>{!! $hotelRoute->hotel_detail->description !!}</span>
			</div>
		</div>       
	</div>
	@if ($hotelRoute->count()-1 != $hotelKey)
		<hr {{-- class="hr-gold" --}}>
	@endif
@endif
