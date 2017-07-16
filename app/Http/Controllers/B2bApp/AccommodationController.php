<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\CruisesController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\HotelApp\HotelsController as DbHotelsController;

class AccommodationController extends Controller
{
	public $viewPath = 'b2b.protected.dashboard.pages.accomo';

	/*
	| this function is to get view on the browser using get request
	*/
	public function getHotelsByToken($token)
	{
		$package = PackageController::call()
								->model()->findByTokenOrExit($token);
		$blade = [
				'package'  => $package,
				'viewPath' => $this->viewPath,
				'client' 	 => $package->client,
				'indication' => indication(),
			];
		return myView($this->viewPath.'.index', $blade);
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


	public function postAccomoFacilities($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postHotelFacilities($request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postCruiseFacilities($request);
		}
		return $result;
	}


	public function postAccomoImages($rid, Request $request)
	{
		$route =  RouteController::call()->model()->find($rid);
		$result = [];
		if ($route->mode == 'hotel') {
			$result = HotelsController::call()->postHotelImages($request);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()->postCruiseImages($request);
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


	public function searchProp($rid, Request $request)
	{
		$result = [];
		$route =  RouteController::call()->model()->find($rid);
		if ($route->mode == 'hotel') {
			$location = $route->destination_detail;
			$params = [
						'name' => $request->term,
						'latitude' => $location->latitude, 
						'longitude' => $location->longitude, 
						'maxRating' => 5,
						'minRating' => 0,
					];

			if ($request->want == 'name') {
				$params['nameOnly'] = 1;
			}

			$result = DbHotelsController::call()
								->model()->fatchHotels($params);
		}
		elseif ($route->mode == 'cruise') {
			$result = CruisesController::call()
								->searchCruiseNames($rid, $request);
		}

		if (strtolower($request->format) == 'json') {
			$result = json_encode($result);
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
