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
		return myView($viewDir.'.index', $blade);
	}


	/*
	| getting hotels list if want hotel with 
	| name then pass name parameter
	| if want as json then pass format = json 
	| default is object
	*/
	public function postAccomo($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = '[]';
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postHotelFromDb($rid, $request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postOnlyCruise($rid, $request);
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
			$result = CruisesController::call()
								->postRemoveCruiseCabin($rid, $request);
		}

	}

	public function searchPropNames($rid, Request $request)
	{
		$result = [];
		$route =  RouteController::call()->model()->find($rid);
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()
								->searchHotelNames($rid, $request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()
								->searchCruiseNames($rid, $request);
		}

		return $result;
	}

	public function postAddAttributes($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		if (isset($request->pick_up) && isset($request->is_pick_up)) {
			$route->is_pick_up = $request->is_pick_up;
			$route->pick_up = $request->pick_up;
		}
		
		if (isset($request->drop_off) && isset($request->is_drop_off)) {
			$route->is_drop_off = $request->is_drop_off;
			$route->drop_off = $request->drop_off;
		}

		if (isset($request->breakfast)) {
			$route->is_breakfast = $request->breakfast;
		}


		if (isset($request->lunch)) {
			$route->is_lunch = $request->lunch;
		}

		if (isset($request->dinner)) {
			$route->is_dinner = $request->dinner;
		}

		$route->save();
	}

}
