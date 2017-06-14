<?php


	Route::group(['namespace' => 'CommonApp'], function(){
		Route::get(
				'location/detail/fatch/airport', 
				'AirportController@getAirport'
			)->name('fatchAirports');

		Route::get(
				'location/detail/fatch/destination', 
				'DestinationController@getDestination'
			)->name('fatchDestinations');
	});