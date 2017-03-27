<?php
	$uniqueKey = $hotelRoom->detail->HotelInfoResult->HotelDetails->HotelCode; 
	$uniqueKey = str_replace('|', '_', $uniqueKey);
?>
<div id="{{ $uniqueKey }}a" class="tab-pane active">
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.tbtq_partials.rooms')
</div>
<div id="{{ $uniqueKey }}b" class="tab-pane">
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.tbtq_partials.about')
</div>
<div id="{{ $uniqueKey }}c" class="tab-pane">
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.tbtq_partials.map')
</div>
<div id="{{ $uniqueKey }}d" class="tab-pane">
	@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.tbtq_partials.gallary')
</div>