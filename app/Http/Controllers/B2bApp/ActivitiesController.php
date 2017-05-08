<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

// =============================ActivityApp Controller=============================
use App\Http\Controllers\ActivityApp\ActivityController;
use App\Http\Controllers\ActivityApp\AgentActivitiesController;

// =============================B2b Controller=============================
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\FgfActivitiesController;
use App\Http\Controllers\B2bApp\ViatorActivitiesController;
use App\Http\Controllers\B2bApp\SelectedActivitiesController;

// =================================Models=================================
use App\Models\B2bApp\PackageActivityModel;


class ActivitiesController extends Controller
{

	public static function call(){
		return new ActivitiesController;
	}

	/*
	| this function is to return the model 
	*/
	public function model()
	{
		return new PackageActivityModel;
	}


	/*
	| this function is to create new row in activity table
	| $params = (object)[
	|		"byHotelId" => boolean // if this is true then only hotel id required
	|		"packageDbId" => null,
	|		"hotelId" => null,
	|		"cityId" => null,
	|		"startDate" => null,
	|		"endDate" => null,
	|		"location" => null,
	|	];
	*/
	public function createNew($params = [], $onlyId = false)
	{
		/*$packageActivity = $this->isExist($params->route_id);
		
		if (is_null($packageActivity)) {
			$packageActivity = new PackageActivityModel;
		}*/

		// $packageActivity->route_id = $params->route_id; // removed bcoz route_package_modes
		
		$packageActivity = new PackageActivityModel;
		$packageActivity->status = 'active';
		$packageActivity->save();
		
		if ($onlyId) {
			$packageActivity = $packageActivity->id;
		}

		return $packageActivity;
	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($routeDbId)
	{
		$packageActivity = PackageActivityModel::select()
											->where([
														"route_id" => $routeDbId,
													])
												->first();

			return $packageActivity;
	}


	/*
	| this function is to get view on the browser using get request
	*/
	public function getActivitiesByToken($token)
	{
		$package = PackageController::call()->model()->findByTokenOrExit($token);
		$viewPath = 'b2b.protected.dashboard.pages.activities';
		$blade = [
				'package' => $package,
				'client' => $package->client,
				'viewPath' => $viewPath
			];
		return trimHtml(view($viewPath.'.index', $blade)->render());
	}


	public function postFatchActivities($rid){
		$selectedActivities = $this->selectedActivities($rid);
		$route = RouteController::call()->model()->find($rid);
		$dbActivities = ActivityController::call()
									->activities($route->destination_detail->id);
		$activities = $this->mergeActivities($selectedActivities, $dbActivities);
		return json_encode(['activities' => array_values($activities)]);
	}


	public function postAddActivity($rid, Request $request)
	{
		$packageActivity = $this->model()->find($request->pdid);
		
		if (is_null($packageActivity)) {
			$packageActivity = $this->model();
		}
		$date = date_formatter($request->date, 'd/m/Y');
		$activityType = '';
		if ($request->vendor == 'f') {
			$activityType = 'App\\Models\\ActivityApp\\ActivityModel';
		}
		elseif ($request->vendor == 'v') {
			$activityType = 'App\\Models\\ActivityApp\\ViatorActivityModel';
		}
		elseif ($request->vendor == 'own') {
			$activityType = 'App\\Models\\ActivityApp\\AgentActivityModel';
		}

		$packageActivity->route_id = $rid;
		$packageActivity->mode = $request->mode;
		$packageActivity->date = $date;
		$packageActivity->activity_id = $request->code;
		$packageActivity->activity_type = $activityType;
		$packageActivity->timing = $request->timing;
		$packageActivity->save();
		return json_encode(['pdid' => $packageActivity->id]);
	}


	public function postRemoveActivity($rid, Request $request)
	{
		if ($request->pdid) {
			$packageActivity = $this->model()->find($request->pdid);
			$packageActivity->is_active = 0;
			$packageActivity->save();
		}

		return json_encode(['status' => 200, 'response' => 'deleted']);
	}



	/*
	| this function is to fatch data date wise
	*/
	public function dateWiseActivity($data)
	{
		$result = [];

		$activitiesResults = $data->activities->activitiesResult;
		foreach ($activitiesResults as $activitiesResult) {
			$activities = $activitiesResult->ActivitySearchResult->ActivityResults;
			foreach ($activities as $activity) {
				$date = date_formatter($activity->date, 'd/m/Y');
				$result[$date][] = $activity->ActivityData;
			}
		}

		return $result;
	}


	public function selectedActivities($rid)
	{
		$packageActivities = $this->model()->findByRouteId($rid);
		$activities = [];
		foreach ($packageActivities as $packageActivity) {
			$activity = $packageActivity->activityObject();
			if (!is_null($activity)) $activities[$activity->ukey] = $activity;
		}
		return $activities;
	}


	/*this function is to merge selected and db actvities*/
	public function mergeActivities($selectedActivities, $activities)
	{
		foreach ($activities as $key => $activity) {
			if (!isset($selectedActivities[$key])) {
				$selectedActivities[$key] = $activity;
			}
		}
		return $selectedActivities;
	}

	public function getActivityNames($rid, Request $request)
	{
		$name = $request->term;
		$route = RouteController::call()->model()->find($rid);
		$names = ActivityController::call()
									->activityNames($route->destination_detail->id, $name);

		if ($request->format == 'json') {
			$names = json_encode($names);
		}
		return $names;
	}

	public function postActivitiesSearch($rid, Request $request)
	{
		$name = $request->term;
		$route = RouteController::call()->model()->find($rid);
		$activities = ActivityController::call()
									->searchActivities($route->destination_detail->id, $name);
		return json_encode(['activities' => array_values($activities)]);
	}



	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postUnionActivitiesResult($id)
	{
		$packageActivity = PackageActivityModel::find($id);
		$result = (object)['activities' => ''];

		$fgfCityId = isset($packageActivity->route->location_hotel->fgf_destinationcode)
							 ? $packageActivity->route->location_hotel->fgf_destinationcode
							 : '';

		$viatorCityId = isset($packageActivity->route->location_viator->destinationId)
									? $packageActivity->route->location_viator->destinationId
									: '';

		
		$params = [
				"fgf_city_id" => $fgfCityId,
				"viator_city_id" => $viatorCityId
			];

		$activities = ActivityController::call()->model()->unionActivities($params);
		// $packageActivity->union_temp_activity_id = $activities->db->id;
		$packageActivity->save();
		$result->activities =  $activities;
		return json_encode($result);
	}



	/*
	| this function is to pull data from Skyscanner api using 
	| SkyscannerHotelApiController and it can be call using http post request
	*/
	public function postViatorActivitiesResult($id)
	{
		$packageActivity = PackageActivityModel::find($id);

		$result = '';

		if (!is_null($packageActivity)) {
			$result = SkyscannerHotelApiController::call()->hotels($packageActivity);
		}

		if (isset($result->db->id)) {
			$packageActivity->skysacanner_temp_hotel_id = $result->db->id;
			$packageActivity->save();
		}

		return json_encode($result);
	}



	public function saveActivities($id, Request $request)
	{
		$packageActivities = PackageActivityModel::find($id);

		$selectedIndex = isset($request->activities)
									 ? $request->activities
									 : [];
									 
		if (isset($request->own_activities)) {
			$destinationId = $packageActivities->route
												->location_hotel->fgf_destinationcode;

			$agentActivities = AgentActivitiesController::call()
												->insertOwnActivities(
															$request->own_activities, 
															$destinationId
														);

			$selectedIndex = array_merge($selectedIndex, $agentActivities['selectedIndex']);
		}

		$selectedIndex = $this->arrayForBulkInsert($selectedIndex, $id);

		SelectedActivitiesController::call()->inactiveOld($id)
																					->bulkInsert($selectedIndex, $id);
		$packageActivities->save();

		return json_encode(['saved' => true]);
	}


	public function arrayForBulkInsert($data, $packageActivityId)
	{
		$selectedActivities = [];
		foreach ($data as $activity) {
			$activity = (object) $activity;
			$code = $activity->activityCode;
			
			if ($activity->vendor == 'f') {
				$code = str_replace('ACTV', '', $code);
			}

			$selectedActivities[] = [
					"package_activity_id" => $packageActivityId,
					"code" => $code,
					"mode" => $activity->mode,
					"date" => date_formatter($activity->date, 'd/m/Y'),
					"vendor" => $activity->vendor,
					"timing" => $activity->timing,
					"created_at" => date('Y-m-d H:i:s'),
					"updated_at" => date('Y-m-d H:i:s') 
				]; 
		}

		return $selectedActivities;
	}


	public function searchActivities($id, Request $request)
	{
		$packageActivity = PackageActivityModel::find($id);

		$fgfCityId = isset($packageActivity->route->location_hotel->fgf_destinationcode)
							 ? $packageActivity->route->location_hotel->fgf_destinationcode
							 : '';

		$viatorCityId = isset($packageActivity->route->location_viator->destinationId)
									? $packageActivity->route->location_viator->destinationId
									: '';

		$params = [
				"name" => $request->term,
				"fgf_city_id" => $fgfCityId,
				"viator_city_id" => $viatorCityId
			];

		$activities = ActivityController::call()->model()
									->searchActivitiesByName($params);

		$activityNames = [];
		foreach ($activities as $activity) {
			$activityNames[] = $activity->name;
		}


		if ($request->format == 'json') {
			$activityNames = json_encode($activityNames);
		}

		return $activityNames;
	}


	public function findActivity($id, Request $request)
	{
		$packageActivity = PackageActivityModel::find($id);

		$fgfCityId = isset($packageActivity->route->location_hotel->fgf_destinationcode)
							 ? $packageActivity->route->location_hotel->fgf_destinationcode
							 : '';

		$viatorCityId = isset($packageActivity->route->location_viator->destinationId)
									? $packageActivity->route->location_viator->destinationId
									: '';

		$params = [
				"name" => $request->name,
				"fgf_city_id" => $fgfCityId,
				"viator_city_id" => $viatorCityId
			];

		$activity = ActivityController::call()->model()->searchActivityByName($params);
		$activity = ["activities" => $activity];
		$activity = json_encode($activity);

		return $activity;
	}



}
