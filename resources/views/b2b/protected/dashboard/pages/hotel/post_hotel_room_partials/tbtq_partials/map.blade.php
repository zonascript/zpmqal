@if (isset($hotelRoom->detail->HotelInfoResult->HotelDetails->Latitude) && isset($hotelRoom->detail->HotelInfoResult->HotelDetails->Longitude))
	<div class="m-top-5">
		<iframe width="100%" height="360" src = "https://maps.google.com/maps?q={{$hotelRoom->detail->HotelInfoResult->HotelDetails->Latitude}},{{$hotelRoom->detail->HotelInfoResult->HotelDetails->Longitude}}&hl=es;z=14&amp;output=embed"></iframe>
	</div>
@else
	<div class="m-top-5">
		<iframe width="100%" height="360" src = "https://maps.google.com/maps?q=&hl=es;z=14&amp;output=embed"></iframe>
	</div>
@endif