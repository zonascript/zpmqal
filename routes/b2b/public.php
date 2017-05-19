<?php 
	Route::get('', 'B2bApp\PagesController@getIndex');
	Route::get('a/l/htdetail', 'HotelApp\AgodaHotelsController@loopHotelDetails');
	Route::get('tp/hotels/result','Api\TravelportHotelApiController@hotels');
