<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ======================================Models======================================
use App\Models\BackendApp\ActivityChildChargeModel;


class ActivityChildChargesController extends Controller
{
  public static function call(){
		return new ActivityChildChargesController;
	}

	public function model(){
		return new ActivityChildChargeModel; 
	}
}
