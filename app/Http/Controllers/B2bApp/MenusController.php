<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// =================================B2b Contrller=================================
use App\Http\Controllers\B2bApp\CabsController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\FlightsController;
use App\Http\Controllers\B2bApp\FollowUpController;
use App\Http\Controllers\B2bApp\ActivitiesController;

class MenusController extends Controller
{
	public static function call(){
		return new MenusController;
	}

	public function getPackageMenus($packageDbId){
		$followUps = $this->getFollowUps();
		$cabs = CabsController::call()->getAllCabs($packageDbId);
		$flights = FlightsController::call()->getAllFlights($packageDbId);
		$hotels = HotelsController::call()->hotelList($packageDbId, false);
		// $activities = ActivitiesController::call()->getAllActivities($packageDbId);
		$activities = [];
		$result = (object)[
			"hotels" => $hotels,
			"flights" => $flights,
			"activities" => $activities,
			"cabs" => $cabs,
			"followUps" => $followUps
		];
		return $result;
	}

	public function getFollowUps(){
		return FollowUpController::call()->all();
	}
}
