<?php
	$uniqueKey = $hotelRoom->hotels[0]->hotel_id; 
	$imageHost = isset($hotelRoom->image_host_url)
						 ? $hotelRoom->image_host_url
						 : urlImage('iamges');

	$ssImages = isset($hotelRoom->hotels[0]->images) 
					? ssImageArrayFix($hotelRoom->hotels[0]->images, $imageHost)
					: [];
	$imageCount = count($ssImages);
?>
@if (isset($hotelRoom->hotels[0]))
	<div id="{{ $uniqueKey }}a" class="tab-pane active">
		@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.skyscanner_partials.rooms')
	</div>
	<div id="{{ $uniqueKey }}b" class="tab-pane">
		@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.skyscanner_partials.about')
	</div>
	<div id="{{ $uniqueKey }}c" class="tab-pane">
		@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.skyscanner_partials.map')
	</div>
	<div id="{{ $uniqueKey }}d" class="tab-pane">
		@include('b2b.protected.dashboard.pages.hotel.post_hotel_room_partials.skyscanner_partials.gallary')
	</div>
@endif