<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ====================================Models====================================
use App\Models\CruiseApp\CruisePriceModel;

class CruisePriceController extends Controller
{
	public static function call()
	{
		return new CruisePriceController;
	}

	public function model()
	{
		return new CruisePriceModel;
	}


}
