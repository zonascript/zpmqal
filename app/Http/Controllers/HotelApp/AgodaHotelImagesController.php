<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===========================Models===========================
use App\Models\HotelApp\AgodaHotelImageModel;

class AgodaHotelImagesController extends Controller
{
	public static function call()
	{
		return new AgodaHotelImagesController;
	}

	public function model()
	{
		return new AgodaHotelImageModel;
	}

}
