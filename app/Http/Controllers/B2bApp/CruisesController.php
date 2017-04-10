<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ================================B2bApp Controller===============================
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\RouteController;

// =================================Api Controller=================================
use App\Http\Controllers\Api\CruiseController;
use App\Http\Controllers\Api\DestinationController;

// =====================================Model======================================
use App\Models\B2bApp\PackageCruiseModel;

use Auth;


class CruisesController extends Controller
{

	public static function call()
	{
		return new cruisesController;
	}

	public function model()
	{
		return new PackageCruiseModel;		
	}


	public function findByRouteId($routeId, $colunm = '*')
	{
		return PackageCruiseModel::select($colunm)
															->where(['route_id' => $routeId])
																->first();
	}


	public function createNew($object)
	{
		$packageCruise = $this->isExist($object->route_id);
		
		if (is_null($packageCruise)) {
			$packageCruise = new PackageCruiseModel;
		}

		$packageCruise->route_id = $object->route_id;
		$packageCruise->status = "active";
		$packageCruise->save();

		return $packageCruise->id;
	}


	public function createNewByRoute($routeDbId)
	{

		$route = RouteController::call()->find($routeDbId);
		$package = PackageController::call()->find($route->package_id);

		$events = json_decode($route->events);

		$destination = $route->destination;
		$destination = explode(' | ', $route->destination);
		$destination = 	ifset($destination[1], $destination[0]);

		// dd_pre_echo($destination);
		$destinationArray = DestinationController::call()->search($destination);
		// echo $destinationArray;
		// dd_pre_echo($destinationArray);
		$city_id = isset($destinationArray->id) ? $destinationArray->id : $destination;

		$newcruiseDetail = (object)[
				'package_id' => $route->package_id, 
				'route_id' => $routeDbId, 
				'city_id' => $city_id, 
				'check_in_date' => $events->cruise->startDate, 
				'nights' => $route->nights, 
				'room_guests' => $package->guests_detail, 
				'location' => json_encode($destinationArray)
			];

		return $this->createNew($newcruiseDetail);

	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($routeDbId)
	{
		$packageCruise = PackageCruiseModel::select()
											->where([
													"route_id" => $routeDbId,
													])
												->first();

		return $packageCruise;
	}



	/*
	| this function is to get view on the browser using get request
	*/
	public function getCruisesByPackageId($packageDbId)
	{
		$package = PackageController::call()->model()->usersFind($packageDbId);
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		return view('b2b.protected.dashboard.pages.cruises.index', $blade);
	}


	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postFgfOnlyCruise($id)
	{
		$packageCruise = PackageCruiseModel::find($id);
		$params = [
				'nights' =>  $packageCruise->route->nights,
				'date' => $packageCruise->route->start_date, 
				'cityId' =>  $packageCruise->route->destination_detail->fgf_destinationcode, 
			];

		$result = CruiseController::call()->cruises($params);

		return json_encode(['cruises' => $result]);
	}


	/*
	| this function for book cabin mean save id or index
	*/
	public function postBookCrusieCabin($packageCruiseId, Request $request)
	{
		$packageCruise = PackageCruiseModel::find($packageCruiseId);
		$packageCruise->cruise_cabin_id = $request->cbid;
		$packageCruise->selected_cruise_vendor = $request->vdr;
		$packageCruise->status = 'complete';
		$packageCruise->route->pick_up = $request->pu;
		$packageCruise->route->is_pick_up = $request->pus;
		$packageCruise->route->drop_off = $request->do;
		$packageCruise->route->is_drop_off = $request->dos;
		$packageCruise->route->status = 'complete';
		$packageCruise->route->save();
		$packageCruise->save();
		return json_encode(['status' => 200, 'response' => 'done']);
	}



	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postFgfCruiseResult($id)
	{
		// return file_get_contents(public_path('faker\fgfcruise.json'));

		$packageCruise = PackageCruiseModel::find($id);
		$adultCount = isset($packageCruise->route->package->pax_detail->adult)
								? $packageCruise->route->package->pax_detail->adult
								: 0;

		$params = [
				"checkInDate" => $packageCruise->route->start_datetime->date,
				"city_id" => $packageCruise->route->destination_detail->fgf_destinationcode,
				"nights" => $packageCruise->route->nights,
				"adultCount" => $adultCount,
				"childAge" => [], 
				"minRating" => 1,
				"maxRating" => 5,
				"PreferredCurrency" => "INR",
			];

		if (!is_null($params)) {
			$result = CruiseController::call()->cruise($params);
		}

		if (isset($result->db->id)) {
			$packageCruise->fgf_temp_cruise_id = $result->db->id;
			$packageCruise->save();
		}
		return json_encode($result);
	}


	/*
	| this function is to pull data from tbtq api using TbtqHotelApiController
	| and it can be call using http post request
	*/
	public function postFgfCruiseCabin($id)
	{
		// return file_get_contents(public_path('faker\fgfcruise.json'));
		$index = 0;
		$packageCruise = PackageCruiseModel::find($id);

		$resultIndex = $packageCruise->fgfTempCruise
									->result->cruises[$index]->resultIndex;

		$adultCount = isset($packageCruise->route->package->pax_detail->adult)
								? $packageCruise->route->package->pax_detail->adult
								: 0;

		$params = [
				"resultIndex" => $resultIndex,
				"checkInDate" => $packageCruise->route->start_datetime->date,
				"nights" => $packageCruise->route->nights,
				"adultCount" => $adultCount,
				"childAge" => [], 
				"minRating" => 1,
				"maxRating" => 5,
			];

		$result = CruiseController::call()->cruiseCabin($params);

		if (isset($result->db->id)) {
			$packageCruise->fgfTempCruise->temp_selected_index = $index;
			$packageCruise->fgfTempCruise->fgf_temp_cruise_detail_id = $result->db->id;
			$packageCruise->fgfTempCruise->save();
			$packageCruise->save();
		}
		return json_encode($result);
	}
	


	public function deleteByRoute($routeDbId)
	{
		PackageCruiseModel::where('route_id', $routeDbId)->update(["status" => "Inactive"]);
		return true;
	}


	public function cruiseDays($cruiseDay = 0)
	{
		if ($cruiseDay == 1) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 2) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 3) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 4) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 5) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 6) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}elseif ($cruiseDay == 7) {
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}else{
			$itinerary = 'Transfer to the cruise arrive at the cruise after check in enjoy the moment of cruise feel the wind of the ocean see the deep sea and the blue water.'; 
		}

		return $itinerary;
		
	}

}
