<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =============================Models=============================
use App\Models\CruiseApp\CruiseOnlyDateModel;

class CruiseOnlyDatesController extends Controller
{

	public static function call()
	{
		return new CruiseOnlyDatesController;
	}

	public function model()
	{
		return new CruiseOnlyDateModel;
	}

}
