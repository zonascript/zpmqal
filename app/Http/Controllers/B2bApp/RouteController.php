<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ================================B2b Controller================================
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\RoomGuestsController;

// ================================Api Controller================================
use App\Http\Controllers\B2bApp\DestinationController;

// ====================================Models====================================
use App\Models\B2bApp\RouteModel;

use Auth;


class RouteController extends Controller
{
	public static function call()
	{
		return new RouteController;
	}

	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($id)
	{
		$bladeData = ["client" => ClientController::call()->info($id)];
		return view('b2b.protected.dashboard.pages.route.create', $bladeData);
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store($id, Request $request)
	{
  	ClientController::call()->activeClient($id);
		
		$request->route = rejson_decode($request->route);

		$nights = 0;
		// =======================Calculation Total Nights=======================
		foreach ($request->route as $routeKey => $routeValue) {
			$nights += isset($routeValue->nights) ? $routeValue->nights : 0;			
		}

		// ================Making Data for package inserting row=================

		$startDate = date_formatter($request->startDate,'d/m/Y');

		$pacakgeData = (object)[
				"client_id" => $id, 
				"start_date" => $startDate, 
				"end_date" => addDaysinDate($startDate,$nights+1),
				"guests_detail" => $request->roomGuests,
				"req" => $request->req
			];

		// ========================creating package here=========================
		$package = PackageController::call()->createNew($id, $pacakgeData);


		// =============================initializing=============================
		$previousNights = 0;
		$firstRouteDbId = null;

		$this->inactiveByPackageId($package->id);
		
		foreach ($request->route as $key => $value) {

			// =============================overwrited=============================
			$startDate = addDaysinDate($startDate, $previousNights);
			$startDate = isset($value->origin_time) 
								 ? $startDate.' '.timeFull($value->origin_time).':00'
								 : $startDate.' 00:00:00';

			$previousNights = isset($value->nights) ? $value->nights : 0;

			// ============================saving Route============================
		

			$route = new RouteModel;
			$route->package_id = $package->id;
			$route->mode = $value->mode;
			$route->origin = isset($value->origin) ? $value->origin : '';
			$route->destination = $value->destination;
			$route->nights = isset($value->nights) ? $value->nights : 0;
			$route->start_date = $startDate;
			$route->end_date = isset($value->destination_time) 
												 ? '0000-00-00 '.timeFull($value->destination_time).':00'
												 : '0000-00-00 00:00:00';
			$route->status = 'active';
			$route->save();
			

			// ===================storing first route id here===================
			if ($firstRouteDbId == null) {
				$firstRouteDbId =  $route->id;
			}
		}

		$nextEvent = PackageController::call()->findEvent($package->id);
		return $nextEvent;
	}





	public function inactiveByPackageId($packageDbId)
	{
		$result = RouteModel::where(['package_id' => $packageDbId])
													->update(['status' => 'inactive']);

		return $result; 
	}



	/*
	| this function is to find route by using package table id 
	*/
	public function allByPackageId($packageDbId)
	{
		return RouteModel::select()->where(["package_id" => $packageDbId])->get();
	}





	public function findByPackageid($packageDbId)
	{
		return RouteModel::select()->where(["package_id" => $packageDbId])->get();
	}


	/*
	| this functio is to find route with with package 
	*/
	public function find($id)
	{
		return RouteModel::with('package')->find($id);
	}


	/*
	| if there is no action on route the run this function 
	| this will change the status into "complete" with current user
	*/
	public function complete($id)
	{
		return RouteModel::where('id', $id)->update(['status' => 'complete']);
	}



	/*
	| this function is to find next route id 
	| if there is no route then it will return 'null'
	*/
	public function findNextRoute($packageDbId, $routeDbId)
	{	
		$route = RouteModel::select()
						->where([
									["package_id", "=", $packageDbId], 
									["id", ">", $routeDbId]
								])
							->first();
		return $id;
	}




	/*
	| this function is to find all route after give id included with current route id
	*/
	public function findAfterRouteId($packageDbId, $routeDbId){
		$result = RouteModel::select()
							->where([
										["package_id", "=", $packageDbId], 
										["id", ">=", $routeDbId]
									])
								->get();
		return $result;
	}




	/*
	| this function is for shifting date and 
	| there is two params is needed package table id and route table id 
	*/
	public function shiftDates($packageDbId, $routeDbId){
		/*
		| this function is finding all route 
		| after given route id with include this route id 
		*/
		$routes = $this->findAfterRouteId($packageDbId, $routeDbId);
		
		$shifted = false;

		if (isset($routes[0])) {

			$firstRouteEndDate = date_formatter($routes[0]->end_date, 'Y-m-d H:i:s');

			foreach ($routes as $routeKey => $route) {
				if ($routeKey) {
					
					$routeStartDate =	date_formatter($route->start_date, 'Y-m-d H:i:s');

					if ($routeStartDate == $firstRouteEndDate) {
						break;
					}
					else{
						$shifted = true;
						$route->start_date = $firstRouteEndDate.substr($route->start_date, 10);
						$routeEndDate = addDaysinDate($firstRouteEndDate, $route->nights);
						$route->end_date  = $routeEndDate.substr($route->end_date, 10);
						$route->save();
						$firstRouteEndDate = $routeEndDate;
					}
				}
			}	
		}
		
		// if ($shifted) {
		// 	ActivitiesController::call()->delete($packageDbId);
		// }

		PackageController::call()->setDates($packageDbId);
		
		return $shifted;
	}

}
