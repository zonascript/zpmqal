<?php
		
	Route::group(['prefix' => 'dashboard/package/builder/accommodation'], function () {
		Route::get('{token}', 'AccommodationController@getHotelsByToken')
						->middleware('packageIsLock')->name('accommo');
		Route::post('remove/{routeId}', 'AccommodationController@postRemoveAccomo');
		Route::post('prop/add/{routeId}', 'AccommodationController@postAddProp');
		Route::post('prop/remove/{routeId}', 'AccommodationController@postRemoveProp');
	});


	Route::group(['prefix' => 'api/package/accommodation'], function () {
		Route::any('fatch/prop/{rid}', 'AccommodationController@postAccomoProp');
		Route::any('fatch/{rid}', 'AccommodationController@postAccomo');
	});