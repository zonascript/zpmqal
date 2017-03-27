<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ======================================Models======================================
use App\Models\BackendApp\ActivityTimingModel;


class ActivityTimingsController extends Controller
{
	public static function call(){
		return new ActivityTimingsController;
	}

	public function model(){
		return new ActivityTimingModel; 
	}
}
