<?php

Route::group(['namespace' => 'ItineraryApp'], function(){
	Route::group(['prefix' => 'your/package/'], function (){
		Route::get('detail/{token}/{page?}', 'PagesController@pages')
						->name('yourPackage');

		Route::any('payment/{status}/{token}', 'PaymentsController@response')
						->name('payStatusUrl');

		Route::get('reserve/{token}', 'ReservesController@reserve')
						->name('reservePackage');
		Route::get('pay/{token}', 'PaymentsController@payNow')
						->name('payPackage');
	});
});