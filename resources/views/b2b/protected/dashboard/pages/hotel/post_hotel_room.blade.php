@if ($vendor == 'tbtq')
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.tbtq')
@elseif($vendor == 'ss')
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.skyscanner')
@else
	<div><p>Result Not Found</p></div>
@endif