<?php

namespace App\Http\Controllers\CruiseApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class CruisesController extends Controller
{

	public static function call()
	{
		return new CruisesController;
	}

}
