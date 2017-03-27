<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ======================================Models======================================
use App\Models\BackendApp\ActivityCarModel;



class ActivityCarsController extends Controller
{
  public static function call(){
		return new ActivityCarsController;
	}

	public function model(){
		return new ActivityCarModel; 
	}
}
