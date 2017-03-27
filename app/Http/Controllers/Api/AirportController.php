<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Api\AirportModel;


class AirportController extends Controller
{

	public static function call(){
		return new AirportController;
	}

	public function getAirport($search){
		return AirportModel::call()->getAirport($search);
	}

	public function getLocation($search){
		return AirportModel::call()->getLocation($search);
	}

	public function getAirportAndLocation($search){
		return AirportModel::call()->getAirportAndLocation($search);
	}
}
