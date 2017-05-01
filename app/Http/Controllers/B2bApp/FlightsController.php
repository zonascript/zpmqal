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

class FlightsController extends Controller
{

	public static function call()
	{
		return new FlightsController;
	}

	public function findRoute($routeId)
	{
		return RouteController::call()->model()->find($routeId);
	}

	/*
	| this function is to get view on the browser using get request
	*/
	public function getFlightsByToken($token)
	{
		$package = PackageController::call()->model()
									->findByTokenOrExit($token);
		$html = '';
		$blade = [
				'package' => $package,
				'client' => $package->client,
			];

		$html = view('b2b.protected.dashboard.pages.flights.index', $blade)->render();

		return trimHtml($html);
	}



	public function postBookFlightsResult($routeId, Request $request){
		$route = $this->findRoute($routeId);
		$returnArray = error500();
		
		if (!is_null($route)) {

			$vendorModelName = '';
			$vendor = $request->vdr;
			$vendorId = $request->vid;
			$vendorIndex = $request->ind; // this is vendor result's array index
			$bookedFlightDetail = [];

			// ===============booking flight here with respective vendor================
			if ($vendor == 'qpx') {
				$bookedFlightDetail = QpxFlightApiController::call()
															->book($vendorId, $vendorIndex);

				$vendorModelName = 'App\\Models\\Api\\QpxFlightModel';
			}
			elseif ($vendor == 'ss') {
				$vendorModelName = 'App\\Models\\Api\\SkyscannerFlightsModel';
				$bookedFlightDetail = SkyscannerFlightsApiController::call()
															->book($vendorId, $vendorIndex);	
			}//---if there is other fight service provider then use elseif here---

			if (isset($bookedFlightDetail->startDateTime) && isset($bookedFlightDetail->endDateTime)) {
				$route->start_date = $bookedFlightDetail->startDateTime->date;
				$route->start_time = $bookedFlightDetail->startDateTime->time;
				$route->end_date = $bookedFlightDetail->endDateTime->date;
				$route->end_time = $bookedFlightDetail->endDateTime->time;
				$route->fusion_id = $vendorId;
				$route->fusion_type = $vendorModelName;
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

	
	public function removeFlight($routeId)
	{
		$route = $this->findRoute($routeId);
		$route->fusion_id = '';
		$route->fusion_type = '';
		$route->status = 'active';
		$route->save();
	}


	public function postQpxFlightResult($id)
	{
		// return file_get_contents(storage_path('mylocal/faker/qpx.json'));
		$route = RouteController::call()->model()->find($id);
		$result = '';

		if (!is_null($route)) {
			$result = QpxFlightApiController::call()->flights($route);
		}

		return json_encode($result);
	}


	public function postSkyscannerFlightResult($id)
	{
		// $result = file_get_contents(storage_path('faker/ssflight.json'));
		$route = RouteController::call()->model()->find($id);
		$result = '';
		if (!is_null($packageFlight)) {
			$result = SkyscannerFlightsApiController::call()->flights($route);
		}
		return json_encode($result);
	}

}
