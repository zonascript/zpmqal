<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

// =============================Api Controller=============================
use App\Http\Controllers\Api\AgentActivitiesController;

// =============================B2b Controller=============================
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\FgfActivitiesController;
use App\Http\Controllers\B2bApp\UnionActivitiesController;
use App\Http\Controllers\B2bApp\ViatorActivitiesController;

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
	public function createNew($params)
	{
		$packageActivity = $this->isExist($params->route_id);
		
		if (is_null($packageActivity)) {
			$packageActivity = new PackageActivityModel;
		}

		$packageActivity->route_id = $params->route_id;
		$packageActivity->status = 'active';
		$packageActivity->save();

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
	public function getActivitiesByPackageId($packageDbId)
	{
		$package = PackageController::call()->model()->usersFind($packageDbId);
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		// dd($package->hotelRoutes[0]->activities);
		return view('b2b.protected.dashboard.pages.activities.index', $blade);
	}


	/*
	| this function is to find all activities by package table id
	*/
	public function findByPackageId($packageDbId)
	{
		$auth = Auth::user();

		return PackageActivityModel::select()
					->with('hotel')
						->with('fgf')
							->with('viator')
								->where([
											'package_id' => $packageDbId, 
											['status', '<>', 'inactive']
										])
									->get();
	}


	/*
	| this function is pull all activities with to the browser
	*/
	public function getActivities($packageDbId){
		$package = PackageController::call()->model()->usersFind($packageDbId);
		dd($package->routes[0]->activities);
		if (!is_null($package)) {

			//===========================get client information============================
			$client = $package->client;

			// ===every Activities detail here which is belongs to the package table id====
			$packageActivities = $this->findByPackageId($packageDbId);

			// ====================initializing activities variable here==================== 
			$activities = [];

			if (!is_null($packageActivities)) {
				foreach ($packageActivities as &$packageActivity) {
					//Location finding here
					$location = json_decode($packageActivity->hotel->location);
					$startDate = $packageActivity->hotel->check_in_date;
					$endDate = $packageActivity->hotel->check_out_date;

					// ======================storing required detail in db======================
					$packageActivity->city_id = $location->id;
					$packageActivity->location = json_encode($location);
					$packageActivity->start_date = $startDate;
					$packageActivity->end_date = $endDate;

					//
					$activitiesTemp = (object)[];

					if (!is_null($packageActivity->hotel)) {
						// getting total count of pax 
						$activitiesTemp->noOfPax = getPax(json_decode($package->guests_detail));
						$activitiesTemp->location = $location;

						$activitiesTemp
							->selectedActivities = json_decode($packageActivity->selected_activities);

						// fatching data from db
						$activitiesTemp->fgfActivities = FgfActivitiesController::call()
												->activities($location->fgf_destinationcode, $startDate);
						$packageActivity->fgf_temp_activity_id = $activitiesTemp->fgfActivities->db->id;

						// Calling Viator Activity here
						$viatorDestiantion = ViatorActivitiesController::call()
												->searchDestination($location->destination);
						

						$viatorActivitiesResult = [];
						
						if (isset($viatorDestiantion[0]) && isset($viatorDestiantion[0]->destinationId)) {
							$viatorParams =	[
								"startDate" => $startDate,
								"endDate" => $endDate,
								"destId" => $viatorDestiantion[0]->destinationId,
								"currencyCode" => 'USD', 
								"catId" => 0, 
								"subCatId" => 0, 
								"dealsOnly" => false
							];

							$activitiesTemp->viatorActivities = ViatorActivitiesController::call()
																									->getProduct($viatorParams);

							// saving viator activity db id temporary column   
							$packageActivity->viator_temp_activity_id = $activitiesTemp
																													->viatorActivities->db->id;
						}

						// pushing $packhotel in a new index for blade
						$activitiesTemp->model = $packageActivity;

						$packageActivity->save();

						$activities[] = $activitiesTemp;
					}
				}
			}


			//make blade array
			$bladeData = [
					"client" => $client,
					// "menus" => $menus,
					"package" => $package,
					"activitiesSlices" => $activities,
					"urlVariable" => (object)[
						"id" => $client->id,
						"packageId" => getPackageId($packageDbId),
						"packageDbId" => $packageDbId,
					],
			];


			return view('b2b.protected.dashboard.pages.activities.activities', $bladeData);

		}
		else{
			return view('errors.404');
		}
	}


	public function postActivities($packageDbId, Request $request){
		$package = PackageController::call()->model()->usersFind($packageDbId);

		if (!is_null($package)) {

			$requestActivities = [];

			/*
			| making group sliceIndex wise
			| sliceIndex is id of package_activity table id 
			*/
			if (is_array($request->activitiesData)) {
				foreach ($request->activitiesData as $activities_key => $activity) {
					/*----sliceIndex is id of package_activity table id----*/
					$sliceIndex = $activity['sliceIndex'];
					
					/*----------this is the code of activity code----------*/
					$activityCode = $activity['activityCode'];
					
					/*----------------making new array here----------------*/
					$requestActivities[$sliceIndex][$activityCode] = $activity;
				}
			}


			//========================saving data into db========================
			foreach ($requestActivities as $requestActivity_key => $requestActivity) {

				//====================finding package_activity=====================
				$packageActivities = PackageActivityModel::find($requestActivity_key);
				$packageActivities->fgf_activity_id = $packageActivities->fgf_temp_activity_id;
				$packageActivities->viator_activity_id = $packageActivities->viator_temp_activity_id;

				//==================saving selected activity data==================
				$packageActivities->selected_activities = json_encode($requestActivity);
				$packageActivities->save();
			}
			// dd($requestActivities);
		}
		else{
			return jsonError('Invalid Data');
		}
	}




	/*
	| this function is to delete the activity
	*/
	public function delete($packageDbId){
		PackageActivityModel::where('package_id', $packageDbId)
													->update(["status" => "inactive"]);
		return true;
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


	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postUnionActivitiesResult($id)
	{
		$packageActivity = PackageActivityModel::find($id);
		$result = (object)[
				'selected' => $packageActivity->selected_activities,
				'activities' => ''
			];

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

		$activities = UnionActivitiesController::call()->activities($params);
		$packageActivity->union_temp_activity_id = $activities->db->id;
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
									 
		$packageActivities->union_activity_id = $packageActivities
																						->union_temp_activity_id;

		if (isset($request->own_activities)) {
			$destinationId = $packageActivities->route
												->location_hotel->fgf_destinationcode;

			$agentActivities = AgentActivitiesController::call()
													->insertOwnActivities(
																$request->own_activities, $destinationId
															);
			$result = $packageActivities->union->result;
			if (!is_null($result)) {
				$result = array_merge($result, $agentActivities['actvities']);
				$selectedIndex = array_merge($selectedIndex, $agentActivities['selectedIndex']);
			}

			$packageActivities->union->result = $result;
			$packageActivities->union->save();
		}

		$packageActivities->selected_activities = $selectedIndex;
		$packageActivities->save();
		return json_encode(['saved' => true]);
	}

}
