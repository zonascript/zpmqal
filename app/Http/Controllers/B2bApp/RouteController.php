<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ================================B2b Controller================================
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PackageController;

// ====================================Models====================================
use App\Models\B2bApp\RouteModel;


class RouteController extends Controller
{
	public static function call()
	{
		return new RouteController;
	}


	public function model()
	{
		return new RouteModel;
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($id, $token = null)
	{
		$client = ClientController::call()->model()->findByUser($id);
		$packageController = new PackageController;

		if (is_null($token)) {
			$package = $packageController->createTemp($id);
			$token = $package->token;
			return redirect('dashboard/package/route/'.$id.'/'.$token);
		}
		else{
			$package = $packageController->model()->findByTokenOrExit($token);
		}

		$blade = [
				"client" => $client, 
				"package" => $package,
				"routes" => $package->routes
			];

		return view('b2b.protected.dashboard.pages.route.create', $blade);
	}


	public function packageUpdate($id, Request $request)
	{

		$startDate = date_formatter($request->startDate,'d/m/Y');

		// ================Making Data for package inserting row=================
		$pacakgeData = (object)[
				"req" => $request->req,
				"start_date" => $startDate, 
				"guests_detail" => $request->roomGuests,
			];

		// =================making package controller new object=================
		$packageController = new PackageController;

		// ========================updating package here=========================
		$package = $packageController->packageUpdate($request->pid, $pacakgeData);
		$nextEvent = $packageController->findEvent($request->pid);

		return $nextEvent;
	}


	public function storeRow($id, Request $request)
	{
		$route = null;

		if (isset($request->rid) && $request->rid) {
			$route = RouteModel::find($request->rid);
		}
		else{
			$route = new RouteModel;
		}

		$route->package_id = $id;
		$route->mode = $request->mode;
		$route->origin = isset($request->origin) ? $request->origin : '';
		$route->destination = $request->destination;
		$route->nights = isset($request->nights) ? $request->nights : 0;
		if (isset($request->origin_time)) {
			$route->start_time = timeFull($request->origin_time);
		}

		if (isset($request->destination_time)) {
			$route->end_time = timeFull($request->destination_time);
		}

		$route->status = 'active';

		$route->save();
		return $route->id;
	}


	public function updateRoute($id, Request $request)
	{
		$route = RouteModel::find($id);
		if (isset($request->origin)) { $route->origin = $request->origin; }
		if (isset($request->destination)) { 
				$route->destination = $request->destination; 
		}

		$route->save();

		$return = $route->id;

		if ($request->format == 'json') {
			$return = json_encode(["status" => 200, "response" => "route updated"]);
		}

		return $return;
	}


	/*
	| this function is to return json 
	| after creating package
	*/
	public function createPackage($id)
	{
		ClientController::call()->activeClient($id);
		
		/*$data = (object)[
				"start_date" => '0000-00-00',
				"end_date" => '0000-00-00', // init temporary
				"req" => ""
			];*/

		$package = PackageController::call()->createTemp($id);

		return json_encode(['id' => $package->id]);
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
		return RouteModel::where(["package_id" => $packageDbId])->get();
	}



	public function postRemoveFusion($id)
	{
		$route = $this->model()->find($id);
		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';
		$route->save();
		return json_encode(['status' => '200', 'reponse' => 'delete']);
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


	public function deleteRow($id)
	{
		$this->makeStatusDelete($id);
		return json_encode(['status' => 200, 'deleted']);
	}


	public function makeStatusDelete($id)
	{
		$route = RouteModel::find($id);
		if (!is_null($route)) {
			$route->status = 'deleted';
			$route->save();
		}
		return true;
	}



	/**
	 * !!!!!! not in used due to change in route saving every time
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeOld($id, Request $request)
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
}
