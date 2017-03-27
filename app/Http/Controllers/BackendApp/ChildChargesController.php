<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =================================Models=================================
use App\Models\BackendApp\ChildChargeModel;



class ChildChargesController extends Controller
{
	public static function call(){
		return new ChildChargesController;
	}

	public function model(){
		return new ChildChargeModel; 
	}
}
