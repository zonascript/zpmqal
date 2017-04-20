<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\BookingHotelImageModel;

class BookingHotelImagesController extends Controller
{

	public static function call()
	{
		return new BookingHotelImagesController;
	}

	public function model()
	{
		return new BookingHotelImageModel;
	}

	public function bulkInsert(Array $array)
	{
		return BookingHotelImageModel::insert($array);
	}


}
