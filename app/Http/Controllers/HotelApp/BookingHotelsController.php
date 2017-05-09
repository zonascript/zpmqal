<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelModel;

class BookingHotelsController extends Controller
{

	public static function call()
	{
		return new BookingHotelsController;
	}

	public function model()
	{
		return new BookingHotelModel;
	}



}
