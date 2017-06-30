<?php


	Route::group(['namespace' => 'CommonApp'], function(){
		Route::get(
				'location/detail/fatch/airport', 
				'AirportController@getAirport'
			)->name('fatchAirports');

		Route::get(
				'location/detail/airport/names', 
				'AirportController@names'
			)->name('airport.names');

		Route::get(
				'location/detail/fatch/destination', 
				'DestinationController@getDestination'
			)->name('fatchDestinations');
	});

	Route::group(['namespace' => 'FlightApp', 'prefix' => 'flights'], function(){
		Route::get('airline/names', 'AirlinesController@names')
						->name('airlines.name');
	});