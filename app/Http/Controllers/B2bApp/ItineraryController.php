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

			if ($route->mode == 'flight') {
				$flight = $route->flight;
				if ($flight->selected_flight_vendor == 'qpx') {
					$segments = $flight->qpxFlight->segments;
					foreach ($segments as $segment) {
						$departureDate = $segment->departureDateTime->date;
						$arrivalDate = $segment->arrivalDateTime->date;

						$origin = $segment->originCity;
						$originCode = $segment->origin;
						$destination = $segment->destinationCity;
						$destinationCode = $segment->destination;

						$itinerary[$departureDate]['flight'] = true;
						$itinerary[$departureDate]['location'][$originCode] = $origin;
						$itinerary[$departureDate]['body'][] = 'Board a flight from '.$origin.'.';

						$itinerary[$arrivalDate]['flight'] = true;
						$itinerary[$arrivalDate]['location'][$destinationCode] = $destination;
						$itinerary[$arrivalDate]['body'][] = 'Arrived in '.$destination.'.';
					}
				}
				elseif ($flight->selected_flight_vendor == 'ss') {
					$segments = $flight->ssFlight->segments;
					foreach ($segments as $segment) {
						$departureDate = $segment->DepartureTiming->date;
						$arrivalDate = $segment->ArrivalTiming->date;
						$origin = $segment->Origin->Name;
						$originCode = $segment->Origin->Code;
						$destination = $segment->Destination->Name;
						$destinationCode = $segment->Destination->Code;

						$itinerary[$departureDate]['flight'] = true;
						$itinerary[$departureDate]['location'][$originCode] = $origin;
						$itinerary[$departureDate]['body'][] = 'Board a flight from '.$origin.'.';

						$itinerary[$arrivalDate]['flight'] = true;
						$itinerary[$arrivalDate]['location'][$destinationCode] = $destination;
						$itinerary[$arrivalDate]['body'][] = 'Arrived in '.$destination.'.';
					}
				}
			}
			elseif (in_array($route->mode,['hotel', 'land', 'road', 'cruise'])) {
				$hotel = $route->hotel;
				$nights = $route->nights;
				$hotelDate = $route->start_datetime->format('Y-m-d');
				$hotelLocation = $route->location_hotel;
				$hotelImages = $route->images();

				/*$hotelImages = [];
				if ($hotel->selected_hotel_vendor == 'tbtq') {
					$tbtqImages = $hotel->tbtqHotel
												->tbtqDetail->result
													->HotelInfoResult
														->HotelDetails->Images;

					$hotelImages = array_merge($hotelImages, $tbtqImages);
				}
				elseif ($hotel->selected_hotel_vendor == 'ss') {
					$ssImages = $hotel->skyscannerHotel->hotelDetail->images;
					$hotelImages = array_merge($hotelImages, $ssImages);
				}elseif ($hotel->selected_hotel_vendor == 'a') {
					$hotelImages = array_merge($hotelImages, $hotel->agodaHotel->images);
				}*/

				for ($i=1; $i <= $nights+1; $i++) {
					$mode = $route->mode;
					$itinerary[$hotelDate][$mode] = true;
					// $itinerary[$hotelDate]['location'][] = $hotelLocation->country;
					$itinerary[$hotelDate]['location'][] = $hotelLocation->destination;

					if ($i == 1) {
						if ($route->is_pick_up) {
							$itinerary[$hotelDate]['body'][] = 'Pick Up from '.$route->pick_up;
						}

						$itinerary[$hotelDate]['body'][] = 'Then transfer to the '.$mode.' arrive at the '.$mode.' after check in, take some rest.';
					}
					elseif ($i > $nights) {
						$itinerary[$hotelDate]['body'][] = 'Check out from '.$mode;
						if ($route->is_drop_off) {
							$itinerary[$hotelDate]['body'][] = 'Drop to '.$route->drop_off;
						}
					}
					else{
						$itinerary[$hotelDate]['body'][] = 'Breakfast will be served at the '.$mode;
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
				


				//===============================Activities here===============================
				if (isset($route->activities->activities_detail) && !is_null($route->activities->activities_detail)) {
					
					$activitiesDetails = $route->activities->activities_detail;

					/* 
					| this code is commented because of all the activity 
					|	pulling from db and as union (fgf viator)

					$fgfActivities = null;
					if (!is_null($activities->fgf)) {
						$fgfActivities = json_decode($activities->fgf->result);
					}

					$viatorActivities = null;
					if (!is_null($activities->viator)) {
						$viatorActivities = json_decode($activities->viator->result);
					}*/

					//this is temporery array which contain activity name by date so that can be implode
					$tempActivities = [];
					foreach ($activitiesDetails as $activitiesDetail) {
						$activityDate = date_formatter($activitiesDetail->date, 'd/m/Y');
						$tempActivities[$activityDate]['names'][] =  $activitiesDetail->detail->name;
						$tempActivities[$activityDate]['activityImages'][] = $activitiesDetail->detail->image;
						

						/*
						| this code is commented because of all the activity 
						|	pulling from db and as union (fgf viator)
						if ($selectedActivity->vendor == 'fgf' && !is_null($fgfActivities)) {

							$activityDate = date_formatter($selectedActivity->date, 'd/m/Y');
							$tempActivities[$activityDate]['names'][] =  $fgfActivities->ActivitySearchResult
																						->ActivityResults[$selectedActivity->index]
																							->ActivityName;

							if (isset($tempActivities[$activityDate]['activityImages'])) {
								$tempActivities[$activityDate]['activityImages'] 
										= array_merge($tempActivities[$activityDate]['activityImages'], 
											$fgfActivities->ActivitySearchResult
												->ActivityResults[$selectedActivity->index]->Images);
							}
							else{
								$tempActivities[$activityDate]['activityImages'] 
																= $fgfActivities
																	->ActivitySearchResult
																		->ActivityResults[$selectedActivity->index]->Images;
							}
						}
						elseif ($selectedActivity->vendor == 'viator' && !is_null($viatorActivities)) {
							$activityDate = date_formatter($selectedActivity->date, 'd/m/Y');
							$tempActivities[$activityDate]['names'][] =  $viatorActivities
																						->data[$selectedActivity->index]
																							->shortTitle;

							$tempActivities[$activityDate]['activityImages'][] = $viatorActivities
																						->data[$selectedActivity->index]
																							->thumbnailHiResURL;
						}*/
					}

					// pushing temp activities in to itinarary
					foreach ($tempActivities as $tempActivityKey => $tempActivity) {
						$itinerary[$tempActivityKey]['body'][] = 
										'Depart for exciting activities ('.implode(', ', $tempActivity['names']).').';

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
			elseif ($route->mode == 'ferry') {
				$ferryOrigin = $route->origin_detail->destination;
				$ferryDestination = $route->destination_detail->destination;

				$itinerary[$routeStartDate]['location'][] = $ferryOrigin;
				$itinerary[$routeStartDate]['body'][] 
					= 'Board ferry at '.$routeStartTime.' from '.$ferryOrigin.'.';
				
				$itinerary[$routeEndDate]['location'][] = $ferryDestination;
				$itinerary[$routeStartDate]['body'][] 
					= 'Arrived ferry on '.$ferryDestination.' at '.$routeEndTime.'.';
			}elseif ($route->mode == 'train') {
				$trainOrigin = $route->origin_detail->destination;
				$trainDestination = $route->destination_detail->destination;

				$itinerary[$routeStartDate]['location'][] = $trainOrigin;
				$itinerary[$routeStartDate]['body'][] 
					= 'Board train at '.$routeStartTime.' from '.$trainOrigin.'.';
				
				$itinerary[$routeEndDate]['location'][] = $trainDestination;
				$itinerary[$routeStartDate]['body'][] 
					= 'Arrived train on '.$trainDestination.' at '.$routeEndTime.'.';
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
