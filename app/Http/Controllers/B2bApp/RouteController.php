<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\RoomGuestsController;
use App\Models\B2bApp\PackageActivityModel;
use App\Models\B2bApp\RouteModel;
use App\Traits\CallTrait;


class RouteController extends Controller
{
	use CallTrait;
	
	public $viewPath = 'b2b.protected.dashboard.pages.route';

	public function model()
	{
		return new RouteModel;
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($ctoken, $token = null)
	{
		$client = ClientController::call()->model()
							->byUser()->byToken($ctoken)->firstOrFail();

		$packageController = new PackageController;

		if (is_null($token)) {
			$package = $packageController->createTemp($client->id);
			$token = $package->token;
			return redirect()->route('createRoute', [$ctoken, $token]);
		}
		else{
			$package = $packageController->model()
									->byUser()->byToken($token)->first();
		}

		$blade = [
				"client" 		=> $client, 
				"package" 	=> $package,
				"viewPath" 	=> $this->viewPath,
				"routes" 		=> $package->routes,
				"indication" => indication(),
			];

		return view($this->viewPath.'.create', $blade);
	}


	public function packageUpdate($pToken, Request $request)
	{
		$newPkg = new PackageController;
		$package = $newPkg->model()->byUser()
							->byToken($pToken)->first();

		$data = new Request([
				"req" => $request->req,
				"start_date" => date_formatter($request->startDate,'d/m/Y'), 
				// "guests_detail" => $this->makeGuestArray($request->roomGuests),
			]);

		// ======updating package here=======
		$package = $newPkg->packageUpdate($package->id, $data);
		$nextEvent = $newPkg->findEvent($request->pid);

		return $nextEvent;
	}


	public function storeRow($pToken, Request $request)
	{
		$route = $this->model()->byPackageUser()->find($request->rid);

		if (is_null($route)) { 
			$route = new RouteModel; 
		}

		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)->first();

		$route->package_id = $package->id;
		$route->mode = $request->mode;
		$route->origin = isset($request->origin) ? $request->origin : '';
		$route->origin_code = isset($request->origin_code) 
												? $request->origin_code 
												: '';
		$route->destination = $request->destination;
		$route->destination_code = $request->destination_code;
		$route->nights = isset($request->nights) ? $request->nights : 0;
		
		if (isset($request->origin_time)) {
			$route->start_time = timeFull($request->origin_time);
		}

		if (isset($request->destination_time)) {
			$route->end_time = timeFull($request->destination_time);
		}

		$route->status = 'active';

		if (in_array($request->mode, ['bus','ferry','train'])) {
			$route->status = 'complete';
		}

		$route->save();
		return $route->id;
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



	public function storeRoom($pToken, Request $request)
	{
		$package = PackageController::call()->model()
							 ->byUser()->byToken($pToken)->firstOrFail();

		$childAge = is_array($request->children_age) 
							? $request->children_age
							: [];
		$room = new Request([
				'package_id' => $package->id,
				'rooms' => $request->rooms,
				'no_of_adult' => $request->adults,
				'children_age' => $childAge
			]);
		
		$roomGuests = RoomGuestsController::call()
									->createOrUpdate($request->id, $room);

		return json_encode([
								'status' => 200,
								'id' => $roomGuests->id,
								'age_ids' => $roomGuests->childAgeIds(),
								'response' => 'saved successfully'
							]);
	}


	public function removeRoom($id)
	{
		RoomGuestsController::call()->destroy($id);
		return json_encode([
								'status' => 200,
								'response' => 'deleted successfully'
							]);
	}



	public function inactiveByPackageId($pid)
	{
		$result = $this->model()->byPackageId($pid)
										->update(['status' => 'inactive']);
		return $result; 
	}



	/*
	| this function is to find route by using package table id 
	public function allByPackageId($pid)
	{
		return $this->model()->byPackageId($pid)->get();
	}
	*/



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
		return $this->model()->where('id', $id)
						->update(['status' => 'complete']);
	}


	public function deleteRow($rid)
	{
		$this->makeStatusDelete($rid);
		return json_encode(['status' => 200, 'deleted']);
	}


	public function makeStatusDelete($id)
	{
		$route = $this->model()->find($id);
		if (!is_null($route)) {
			$route->status = 'deleted';
			$route->save();
		}
		return true;
	}



	public function copyRoutes($oldPid, $newPid)
	{
		$routes = $this->model()->byPackageId($oldPid)->get();
		foreach ($routes as $route) {
			$newRoute = $this->model();
			$newRoute->package_id = $newPid;
			$newRoute->mode = $route->mode;
			$newRoute->origin = $route->origin;
			$newRoute->destination = $route->destination;
			$newRoute->nights = $route->nights;
			$newRoute->start_date = $route->start_date;
			$newRoute->start_time = $route->start_time;
			$newRoute->end_date = $route->end_date;
			$newRoute->end_time = $route->end_time;
			$newRoute->is_pick_up = $route->is_pick_up;
			$newRoute->pick_up = $route->pick_up;
			$newRoute->is_drop_off = $route->is_drop_off;
			$newRoute->drop_off = $route->drop_off;
			$newRoute->fusion_id = $route->fusion_id;
			$newRoute->fusion_type = $route->fusion_type;
			$newRoute->status = $route->status;
			$newRoute->save();

			if ($route->packageActivities->count()) {
				foreach ($route->packageActivities as $packageActivity) {
					$activity = new PackageActivityModel;
					$activity->route_id = $newRoute->id;
					$activity->mode = $packageActivity->mode;
					$activity->date = $packageActivity->date;
					$activity->timing = $packageActivity->timing;
					$activity->activity_id = $packageActivity->activity_id;
					$activity->activity_type = $packageActivity->activity_type;
					$activity->is_active = $packageActivity->is_active;
					$activity->save();
				}
			}
		}

		return $routes;
	}


	public function makeGuestArray(Array $roomGuests)
	{
		$result = [];
		foreach ($roomGuests as $roomGuest) {
			$childAge = isset($roomGuest['ChildAge'])
								? $roomGuest['ChildAge']
								: [];

			$result[] = [
					"NoOfAdult" => $roomGuest['NoOfAdults'],
					"ChildAge" => $childAge
				];
		}

		return $result;
	}


}