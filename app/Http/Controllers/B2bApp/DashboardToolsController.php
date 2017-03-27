<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// ==============================Api Controller==============================
use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\DestinationController;

use App\Models\Api\Location;
use App\Models\Api\Airport;

class DashboardToolsController extends Controller
{

	public function getIndex(){
		return view('b2b.protected.dashboard.pages.tools.index');
	}

	public function getCalendar(){
		return view('b2b.protected.dashboard.pages.calendar.index');
	}

	public function getDestination(Request $request){
		$tag = isset($request->tags) ? explode('|', $request->tags) : [''];
		$tag = isset($tag[1]) ? $tag[1] : $tag[0];
		$destinationController = new DestinationController;
		$locations = $destinationController->getLocationRight($request->term, $tag);

		if (!$locations->count()) {
			$locations = $destinationController->getLocation($request->term, $tag);
		}

		$locations = makeObject($locations);
		$location_array = [];
		// ddpreecho($locations); 
		if(bool_array($locations)){
			foreach ($locations as $location) {
				$location_array[] = $location->location;
			}
		}

		return json_encode($location_array);
	}

	public function getCountry(){
		$locations = CountryController::call()->getCountry();
		$country_array = [];

		if(bool_array($locations)){
			foreach ($locations as $location) {
				$country_array[] = $location->CountryCode;
			}
		}

		return json_encode($country_array);
	}

	public function getAirport(Request $request){
		
		$airportsData = AirportController::call()
									->getAirportAndLocation($request->input('term'));
									
		$airports = [];
			
		if(bool_array($airportsData)){
			foreach ($airportsData as $airportsData_temp) {
				$airports[] = $airportsData_temp->airports;
			}
		}

		return json_encode($airports);
	}
}
