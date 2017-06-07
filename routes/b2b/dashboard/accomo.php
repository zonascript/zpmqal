<?php
		
	Route::group(['prefix' => 'dashboard/package/builder/accommodation'], function () {
		Route::get('{token}', 'AccommodationController@getHotelsByToken')
						->middleware('packageIsLock')->name('accommo');
		Route::post('remove/{rid}', 'AccommodationController@postRemoveAccomo');
		Route::post('prop/add/{rid}', 'AccommodationController@postAddProp');
		Route::post('prop/remove/{rid}', 'AccommodationController@postRemoveProp');
	});


	Route::group(['prefix' => 'api/package/accommodation'], function () {
		Route::get('search/name/{rid}', 'AccommodationController@searchPropNames');
		Route::post('fatch/prop/{rid}', 'AccommodationController@postAccomoProp');
		Route::post('fatch/{rid}', 'AccommodationController@postAccomo');
	});