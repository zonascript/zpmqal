<?php
		
	Route::group(['prefix' => 'dashboard/package/builder/accommodation'], function () {
		$ac = 'AccommodationController';
		Route::post('add/attributes/{rid}', $ac.'@postAddAttributes');
		Route::post('prop/remove/{rid}', $ac.'@postRemoveProp');
		Route::post('prop/add/{rid}', $ac.'@postAddProp');
		Route::post('remove/{rid}', $ac.'@postRemoveAccomo');
		Route::get('{token}', $ac.'@getHotelsByToken')
						->middleware('packageIsLock')->name('accommo');

	});


	Route::group(['prefix' => 'api/package/accommodation'], function () {
		$ac = 'AccommodationController';
		Route::get('search/name/{rid}', $ac.'@searchPropNames');
		Route::post('fatch/prop/{rid}', $ac.'@postAccomoProp');
		Route::post('fatch/{rid}', $ac.'@postAccomo');
	});