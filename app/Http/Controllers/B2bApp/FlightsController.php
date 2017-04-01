<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// ========================Api Controller========================
use App\Http\Controllers\Api\QpxFlightApiController;
use App\Http\Controllers\Api\SkyscannerFlightsApiController;


// ========================B2b Controller========================
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\ClientController;

// ============================Models============================
use App\Models\B2bApp\PackageFlightModel;

use Auth;


ini_set('max_execution_time', 300);


class FlightsController extends Controller
{

	public static function call()
	{
		return new FlightsController;
	}



	public function createNew($object)
	{
		$packageFlight = $this->isExist($object->route_id);
		
		if (is_null($packageFlight)) {
			$packageFlight = new PackageFlightModel;
		}

		$packageFlight->route_id = $object->route_id;
		$packageFlight->status = "active";
		$packageFlight->save();

		return $packageFlight->id;
	}



	public function createNewByRoute($routeDbId)
	{
		// ====================finding route data using route id====================
		$route = RouteController::call()->find($routeDbId);

		// ==========finding package data using package id from route data==========
		$package = $route->package;
		$guestsDetail = json_decode($package->guests_detail, true);

		// =====getting guest detail here like no. of adult and child with age======
		$pax = $this->getPaxByGlobal($guestsDetail);
		
		$requestData = [ 
				"_token" => csrf_token(),
				"origin" => $route->origin,
				"destination" => $route->destination,
				"arrival" =>  date_formatter($route->start_date, 'Y-m-d H:i:s', 'Y-m-d'),
				"adult" => $pax['adult'],
				"child" => $pax['child'],
				"infant" => $pax['infant']
			];

		$newHotelDetail = (object)[
				'package_id' => $route->package_id, 
				'route_id' => $routeDbId, 
				'request' => json_encode($requestData), 
			];

		$newFlightId = $this->createNew($newHotelDetail);

		return $newFlightId;
	}



	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($routeDbId)
	{
		$packageHotel = PackageFlightModel::select()
										->where(["route_id" => $routeDbId])
											->first();

		return $packageHotel;
	}



	/*
	| this function is to get view on the browser using get request
	*/
	public function getFlightsByPackageId($packageDbId)
	{
		$package = PackageController::call()->model()->usersFind($packageDbId);
		$html = '';
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];
		if ($package->flightRoutes->count()) {
			$html = view('b2b.protected.dashboard.pages.flights.index', $blade)->render();
		}
		else{
			$html = view('b2b.protected.dashboard.pages.flights.404', $blade)->render();
		}

		return trimHtml($html);
	}




	/*
	| this function used for itinarary
	| for package builder menu must have these 
	| Hotel menu data 
	| fight menu data 
	| car menu data
	*/
	public function getFlights($id, $packageDbId, $flightDbId = false){
		echo 'getFlights this method is not used';
		dd($flightDbId);

		$validEnquiry = $this->validEnquiry($id, $packageDbId, $flightDbId);
		
		// dd_pre_echo($validEnquiry);

		if ($validEnquiry == false) {
		
			return view('errors.404');
		
		}
		elseif ($validEnquiry == "new"){
		
			$packageFlightId = $this->createNew($packageDbId);
			// echo $packageFlight->id;
			return redirect("dashboard/package/builder/flight/$id/$packageDbId/$packageFlightId");
		
		}
		elseif ($validEnquiry == "update") {
			
			$client = ClientController::call()->info($id);
			$menus = MenusController::call()->getPackageMenus($packageDbId);
			// dd_pre_echo($menus->flights);
			$bladeData = [
				"client" => $client,
				"urlVariable" => (object)[
					"id" => $id,
					"packageDbId" => $packageDbId,
					"packageId" => getPackageId($packageDbId),
					"flightDbId" => $flightDbId
				],
				"menus" => $menus,
			];

			// pre_echo($bladeData);

			return view('b2b.protected.dashboard.pages.flight.index', $bladeData);

		}

	}

	/*
	| this function is for if we get result then we changed something and 
	| search again from that page where we get result,
	| Mean this function only store $request in package_flights's table 
	| request column as json
	*/
	public function postFlights($flightDbId, Request $request){
		$responce = (object)["nextUrl" => newRedirectUrl(urlFlightsSearch($flightDbId))];

		$packageFlight = PackageFlightModel::call()->usersFind($flightDbId);
		if (!is_null($packageFlight)) {
			$packageFlight->request = json_encode($request->input());
			$packageFlight->save();
			$responce->nextUrl = newRedirectUrl(urlFlightsResult($flightDbId));
		}

		return json_encode($responce);

	}

	public function getFlightsResult($flightDbId){
		
		$packageFlight = PackageFlightModel::call()->usersFind($flightDbId);
		
		if (!is_null($packageFlight)) {
			// this is client data 
			$client = $packageFlight->package->client;

			// ========================this contain request data========================
			$requestData =  json_decode($packageFlight->request);

			// ===================making request array for qpx flight===================
			$postData = [
				"request" => [
					"slice" => [
						[
							"origin" => substr($requestData->origin, 0, 3),
							"destination" => substr($requestData->destination, 0, 3),
							"date" => $requestData->arrival,
						]
					],
					"passengers" => [
						"adultCount" => $requestData->adult,
						"infantInLapCount" => $requestData->infant,
						"infantInSeatCount" => 0,
						"childCount" => $requestData->child,
						"seniorCount" => 0
					],
					"solutions" => 50,
					"refundable" => false
				]
			];

			$qpxResult = QpxFlightApiController::call()->postFlight($postData); 
			
			$packageFlight->qpx_temp_flight_id = $qpxResult->db->id;
			$packageFlight->save();

			$menus = MenusController::call()->getPackageMenus($packageFlight->package->id);

			$bladeData = [
				"package" => $packageFlight->package,
				"client" => $client,
				"urlVariable" => (object)[
						"id" => $client->id,
						"packageDbId" => $packageFlight->package->id,
						"packageId" => getPackageId($packageFlight->package->id),
						"flightDbId" => $flightDbId
					],
				"menus" => $menus,
				"flightsResult" => $qpxResult, 
				"requestData" =>	$requestData,
			];

			return view('b2b.protected.dashboard.pages.flight.result', $bladeData);
		}
		else{
			return redirect('404');
		}
	}


	public function postBookFlightsResult($flightDbId, Request $request){
		$packageFlight = PackageFlightModel::call()->usersFind($flightDbId);
		$returnArray = error500();
		
		if (!is_null($packageFlight)) {
			$route = $packageFlight->route;

			// =================Gettting result after booked the flight=================
			$bookedFlightDetail = [];

			// =============================qpx flight here=============================
			if ($request->vendor == 'qpx') {
				// storing package's selected_flights_vendor column value
				$packageFlight->qpx_flight_id = $packageFlight->qpx_temp_flight_id;
				$packageFlight->selected_flight_vendor = 'qpx';

				// booking flight here with respective vendor
				$bookedFlightDetail = QpxFlightApiController::call()
															->book($packageFlight->qpx_flight_id, $request->index);	
			}
			elseif ($request->vendor == 'ss') {
				// storing package's selected_flights_vendor column value
				$packageFlight->skyscanner_flight_id = $packageFlight->skyscanner_temp_flight_id;
				$packageFlight->selected_flight_vendor = 'ss';

				// booking flight here with respective vendor
				$bookedFlightDetail = SkyscannerFlightsApiController::call()
															->book($packageFlight->skyscanner_flight_id, $request->index);	
			}//---if there is other fight service provider then use elseid here---

			// route id storing in 
			$routeDbId = $packageFlight->route_id;
			
			$packageFlight->status = "complete";
			$packageFlight->save();

			if (isset($bookedFlightDetail->startDateTime) && isset($bookedFlightDetail->endDateTime)) {
				// =============finding route here using route table id =============
				$route->start_date = $bookedFlightDetail->startDateTime->date;
				$route->start_time = $bookedFlightDetail->startDateTime->time;
				$route->end_date = $bookedFlightDetail->endDateTime->date;
				$route->end_time = $bookedFlightDetail->endDateTime->time;
				$route->status = 'complete';
				$route->save();
				$route->fixDates($route->id);

				$returnArray = [ 
					"status" => 200,
					"responce" => 'data saved successfully'
				];

			}
			else{
				$returnArray = error500();
			}

			
		}
		
		return json_encode($returnArray);
	
	}



	public function deleteByRoute($routeDbId)
	{
		return  PackageFlightModel::where('route_id', $routeDbId)
																->update(["status" => "inactive"]);
	}




	public function postQpxFlightResult($id)
	{
		// return $result = file_get_contents(storage_path('mylocal/faker/qpx.json'));

		$packageFlight = PackageFlightModel::find($id);
		
		$result = '';

		if (!is_null($packageFlight)) {
			$result = QpxFlightApiController::call()->flights($packageFlight);
		}

		if (isset($result->db->id)) {
			$packageFlight->qpx_temp_flight_id = $result->db->id;
			$packageFlight->save();
		}
		return json_encode($result);
	}



	public function postSkyscannerFlightResult($id)
	{
		// $result = file_get_contents(storage_path('faker/ssflight.json'));

		$packageFlight = PackageFlightModel::find($id);
		
		$result = '';

		if (!is_null($packageFlight)) {
			$result = SkyscannerFlightsApiController::call()->flights($packageFlight);
		}

		if (isset($result->db->id)) {
			$packageFlight->skyscanner_temp_flight_id = $result->db->id;
			$packageFlight->save();
		}

		return json_encode($result);
	}


	public function getPlacesFormattedAttribute($data)
	{
		$places = [];
		
		if (isset($data)) {
			foreach ($data as $place) {
				$places[$place->Id] = $place;
			}
		}

		return $places;
	}

}
