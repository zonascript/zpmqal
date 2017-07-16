<?php
	$ac = 'AccommodationController';

	Route::group(['prefix' => 'dashboard/package/builder/accommodation'], function () use ($ac) {
		Route::post('add/attributes/{rid}', $ac.'@postAddAttributes');
		Route::post('prop/remove/{rid}', $ac.'@postRemoveProp');
		Route::post('prop/add/{rid}', $ac.'@postAddProp');
		Route::post('remove/{rid}', $ac.'@postRemoveAccomo');
		Route::get('{token}', $ac.'@getHotelsByToken')
						->middleware('packageIsLock')->name('accommo');

	});

	Route::group(['prefix' => 'api/package/accommodation'], function () use ($ac){
		Route::match(
								['get', 'post'], 
								'search/name/{rid}',
								 $ac.'@searchProp'
							)
						->name('accomo.searchProp');
		Route::group(['prefix' => 'fatch'], function () use ($ac){
			Route::post('facilities/{rid}', $ac.'@postAccomoFacilities');
			Route::post('images/{rid}', $ac.'@postAccomoImages');
			Route::post('prop/{rid}', $ac.'@postAccomoProp');
			Route::post('{rid}', $ac.'@postAccomo');
			if (isLocalhost()) {
				Route::get('prop/{rid}', $ac.'@postAccomoProp');
				Route::get('images/{rid}', $ac.'@postAccomoImages');
				Route::get('facilities/{rid}', $ac.'@postAccomoFacilities');
			}
		});
	});