<?php 
	$flightsController = 'FlightsController';
	
	Route::group(['prefix' => 'dashboard/package/builder'], function () {
		Route::get('flights/{token}', 'FlightsController@getFlightsByToken');
		Route::post('flight/book/{routeId}', 'FlightsController@postBookFlightsResult');
		Route::delete('flight/{routeId}', 'FlightsController@removeFlight');
	});

	Route::post(
		'qpx/flights/result/{id}', 
		'FlightsController@postQpxFlightResult'
	);
	
	Route::post(
		'ss/flights/result/{id}', 
		'FlightsController@postSkyscannerFlightResult'
	);

	Route::get('tp/flights/result', 'Api\TravelportAirController@index');
	Route::get('skyscanner/flights', 'Api\SkyscannerFlightsApiController@postFlight');
