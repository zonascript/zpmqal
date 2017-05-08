<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==========================Models==========================
use App\Models\ActivityApp\ViatorActivityModel;

class ViatorActivitiesController extends Controller
{

	public static function call()
	{
		return new ViatorActivitiesController;
	}

	public function model()
	{
		return new ViatorActivityModel;
	}


}
