<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// =================================B2b Controller=================================
use App\Http\Controllers\B2bApp\RouteController;
use App\Http\Controllers\B2bApp\ClientController;
use App\Http\Controllers\B2bApp\CruisesController;
use App\Http\Controllers\B2bApp\HotelsController;
use App\Http\Controllers\B2bApp\PackageController;
use App\Http\Controllers\B2bApp\ActivitiesController;


// =====================================Session====================================
use Auth;


class ItineraryController extends Controller
{
	/*
	| This is function is made for. 
	| if you want to call a non static function without 
	| making object then this function will use 
	| for example $foo = BarClass::call()->foo();
	*/

	public static function call(){
		return new ItineraryController;
	}

	public function itineraryByRoute($packageDbId)
	{
		$package = PackageController::call()->model()->find($packageDbId);
		return $this->itinerary($package);
	}

	public function itinerary($package)
	{
		$itinerary = [];
		foreach ($package->routes as $route) {
			$routeStartDate = $route->start_datetime->format('Y-m-d');
			$routeStartTime = $route->start_datetime->format('H:i');
			$routeEndDate = $route->end_datetime->format('Y-m-d');
			$routeEndTime = $route->end_datetime->format('H:i');
			$origin = $route->origin_detail->destination;
			$destination = $route->destination_detail->destination;

			if ($route->mode == 'flight') {
				$flights = $route->flightDetail();
				foreach ($flights as $key => $flight) {
					$origin = $flight->origin;
					$originCode = $flight->originCode;
					$destination = $flight->destination;
					$destinationCode = $flight->destinationCode;
					$departureDate = $flight->departureDate;
					$arrivalDate = $flight->arrivalDate;

					$itinerary[$departureDate]['flight'] = true;
					$itinerary[$departureDate]['location'][$originCode] = $origin;
					$itinerary[$departureDate]['body'][] = [
								'flight'=>'Board a flight from '.$origin.'.'
							];

					$itinerary[$arrivalDate]['flight'] = true;
					$itinerary[$arrivalDate]['location'][$destinationCode] = $destination;
					$itinerary[$arrivalDate]['body'][] = [
								'flight' => 'Arrived in '.$destination.'.'
							];
				}
			}
			elseif (in_array($route->mode,['hotel', 'land', 'road'])) {
				$hotel = $route->hotelDetail();
				$nights = $route->nights;
				$hotelName = $hotel->name;
				$hotelDate = $route->start_datetime->format('Y-m-d');
				$hotelLocation = $route->destination_detail;
				$hotelImages = $route->images();

				for ($i=1; $i <= $nights+1; $i++) {
					$mode = $route->mode;
					$itinerary[$hotelDate][$mode] = true;
					$itinerary[$hotelDate]['location'][] = $hotelLocation->destination;

					if ($i == 1) {
						if ($route->is_pick_up) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'Pick Up from '.$route->pick_up
								];
						}

						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Then transfer to the '.$mode.' arrive at the '.$hotelName.'('.$mode.') after check in, take some rest.'
							];
					}
					elseif ($i > $nights) {
						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Check out from '.$hotelName.'('.$mode.')'
							];
						if ($route->is_drop_off) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'Drop to '.$route->drop_off
								];
						}
					}
					else{
						$itinerary[$hotelDate]['body'][] = [
							'hotel' => 'Breakfast will be served at the '.$hotelName.'('.$mode.')'
						];
					}


					
					if ($i <= $nights) {
						if (isset($itinerary[$hotelDate]['hotelImages'])) {
							$itinerary[$hotelDate]['hotelImages'] = 
											array_merge($itinerary[$hotelDate]['hotelImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelImages'] = $hotelImages;
						}
					}else{
						if (isset($itinerary[$hotelDate]['hotelCheckOutImages'])) {
							$itinerary[$hotelDate]['hotelCheckOutImages'] = 
											array_merge($itinerary[$hotelDate]['hotelCheckOutImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelCheckOutImages'] = $hotelImages;
						}
					}

					$hotelDate = addDaysinDate($hotelDate,1);
					$hotelImages[] = array_shift($hotelImages);
				}
				
				//=========================Activities here=========================
				if ($route->packageActivities->count()) {

					$tempActivities = [];

					foreach ($route->packageActivities as $packageActivity) {
						$activity = $packageActivity->activityObject(['images']);
						$date = $activity->date;
						$tempActivities[$date]['names'][] =  $activity->name;
						if (!isset($tempActivities[$date]['activityImages'])) {
							$tempActivities[$date]['activityImages'] = [];
						}
						$tempActivities[$date]['activityImages'] = array_merge($tempActivities[$date]['activityImages'],$activity->images);
					}

					// pushing temp activities in to itinarary
					foreach ($tempActivities as $tempActivityKey => $tempActivity) {
						$itinerary[$tempActivityKey]['body'][] = [ 
								'activity' => 'Depart for exciting activities ('.implode(', ', $tempActivity['names']).').'
							];

						if (isset($itinerary[$tempActivityKey]['activityImages'])) {
							$itinerary[$tempActivityKey]['activityImages'] = 
											array_merge($itinerary[$tempActivityKey]['activityImages'], 
												$tempActivity['activityImages']);
						}
						else{
							$itinerary[$tempActivityKey]['activityImages'] = $tempActivity['activityImages'];
						}
					}
				}
			}
			elseif ($route->mode == 'cruise') {
				$hotel = $route->cruiseDetail();
				$nights = $route->nights;
				$hotelName = $hotel->name;
				$hotelDate = $route->start_datetime->format('Y-m-d');
				$hotelLocation = $route->destination_detail;
				$hotelImages = $route->images();

				for ($i=1; $i <= $nights+1; $i++) {
					$mode = $route->mode;
					$itinerary[$hotelDate][$mode] = true;
					$itinerary[$hotelDate]['location'][] = $hotelLocation->destination;

					if ($i == 1) {
						if ($route->is_pick_up) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'Pick Up from '.$route->pick_up
								];
						}

						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Then transfer to the '.$mode.' arrive at the '.$hotelName.'('.$mode.') after check in, take some rest.'
							];
					}
					elseif ($i > $nights) {
						$itinerary[$hotelDate]['body'][] = [
								'hotel' => 'Check out from '.$hotelName.'('.$mode.')'
							];
						if ($route->is_drop_off) {
							$itinerary[$hotelDate]['body'][] = [
									'car' => 'Drop to '.$route->drop_off
								];
						}
					}
					else{
						$itinerary[$hotelDate]['body'][] = [
							'hotel' => 'Breakfast will be served at the '.$hotelName.'('.$mode.')'
						];
					}


					
					if ($i <= $nights) {
						if (isset($itinerary[$hotelDate]['hotelImages'])) {
							$itinerary[$hotelDate]['hotelImages'] = 
											array_merge($itinerary[$hotelDate]['hotelImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelImages'] = $hotelImages;
						}
					}else{
						if (isset($itinerary[$hotelDate]['hotelCheckOutImages'])) {
							$itinerary[$hotelDate]['hotelCheckOutImages'] = 
											array_merge($itinerary[$hotelDate]['hotelCheckOutImages'], $hotelImages);
						}
						else{
							$itinerary[$hotelDate]['hotelCheckOutImages'] = $hotelImages;
						}
					}

					$hotelDate = addDaysinDate($hotelDate,1);
					$hotelImages[] = array_shift($hotelImages);
				}
			}
			elseif ($route->mode == 'ferry') {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'ferry' => 'Board ferry at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'ferry' => 'Arrived ferry on '.$destination.' at '.$routeEndTime.'.'
					];
			}
			elseif ($route->mode == 'train') {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'train' => 'Board train at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'train' => 'Arrived train on '.$destination.' at '.$routeEndTime.'.'
					];
			}
			elseif ($route->mode == 'bus') {
				$itinerary[$routeStartDate]['location'][] = $origin;
				$itinerary[$routeStartDate]['body'][] = [
						'bus' => 'Board bus at '.$routeStartTime.' from '.$origin.'.'
					];
				
				$itinerary[$routeEndDate]['location'][] = $destination;
				$itinerary[$routeStartDate]['body'][] = [
						'bus' => 'Arrived bus on '.$destination.' at '.$routeEndTime.'.'
					];
			}

		}

		$itineraries = [];
		$day = 1;
		foreach ($itinerary as $itineraryKey => &$itineraryValue) {
			$itineraryValue['day'] = $day;
			$itineraryValue['date'] = $itineraryKey;
			if (isset($itineraryValue['location'])) {
				$itineraryValue['location'] = array_values(array_unique($itineraryValue['location']));
			}

			if (!isset($itineraryValue['images'])) {
				$itineraryValue['images'] = [];
			}


			if (isset($itineraryValue['hotelImages']) && isset($itineraryValue['activityImages'])) {
				$itineraryValue['images'] = alternativelyMerge(
									$itineraryValue['hotelImages'], 
									$itineraryValue['activityImages']
								);
			}
			elseif (isset($itineraryValue['hotelImages'])) {
				$itineraryValue['images'] = $itineraryValue['hotelImages'];
			}
			elseif (isset($itineraryValue['activityImages'])) {
				$itineraryValue['images'] = $itineraryValue['activityImages'];
			}
			
			if (isset($itineraryValue['hotelCheckOutImages'])) {
				$itineraryValue['images'] = array_merge(
						$itineraryValue['images'], $itineraryValue['hotelCheckOutImages']);
			}

			$itineraries[] = $itineraryValue;
			$day++;
		}

		return rejson_decode($itineraries);
	}




}
