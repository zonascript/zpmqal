<?php

Route::group(['namespace' => 'AdminApp'], function(){
	Route::get('home', 'PagesController@getHome');
});