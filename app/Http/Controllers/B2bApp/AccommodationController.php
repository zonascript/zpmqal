<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\CruisesController;
use App\Http\Controllers\B2bApp\PackageController;

class AccommodationController extends Controller
{
	
	/*
	| this function is to get view on the browser using get request
	*/
	public function getHotelsByToken($token)
	{
		$package = PackageController::call()->model()->findByTokenOrExit($token);
		$viewDir = 'b2b.protected.dashboard.pages.accomo';
		$blade = [
				'package' => $package,
				'client' => $package->client,
				'viewDir' => $viewDir,
			];
		return trimHtml(view($viewDir.'.index', $blade)->render());
	}


	public function postAccomo($rid)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postHotelFromDb($rid);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postOnlyCruise($rid);
		}
		return $result;
	}


	public function postRemoveAccomo($rid)
	{
		return RouteController::call()->postRemoveFusion($rid);
	}




	public function postAccomoProp($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postHotelRoom($request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postCruiseCabin($request);
		}
		return $result;
	}



	public function postAddProp($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postAddHotelRoom($rid, $request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postAddCruiseCabin($rid, $request);
		}

		return $result;
	}



	public function postRemoveProp($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postRemoveHotelRoom($rid, $request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postRemoveCruiseCabin($rid, $request);
		}

		return $result;
	}
}
