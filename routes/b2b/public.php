<?php 
	Route::get('', 'B2bApp\PagesController@getIndex');

	// This for package html
	Route::get('your/package/detail/{hashId}', 'B2bApp\PdfHtmlController@htmlByHashIdWithTrack');

	Route::get(
						'your/package/detail/{hashId}', 
						'B2bApp\PackageController@showPackageDetail'
					)
				->name('yourPackage');

	Route::get('a/l/htdetail', 'HotelApp\AgodaHotelsController@loopHotelDetails');
	Route::get('tp/hotels/result','Api\TravelportHotelApiController@hotels');
