<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FlightApp\AddedFlightSegmentsController;

use App\Models\B2bApp\RouteModel;
use App\Models\FlightApp\AddedFlightModel;
use Carbon\Carbon;

class AddedFlightsController extends Controller
{
	public static function call()
	{
		return new AddedFlightsController;
	}


	public function model()
	{
		return new AddedFlightModel;
	}


	public function saveFlight(RouteModel $route, Request $reqeust)
	{
		$addedFlight = null;

		if (isset($reqeust->vid)) {
			$addedFlight = $this->model()->find($reqeust->vid);
		}

		if (is_null($addedFlight)) {
			$addedFlight = $this->model();
		}

		$addedFlight->route_id = $route->id;
		$addedFlight->origin = $route->origin_code;
		$addedFlight->destination = $route->destination_code;
		$addedFlight->date = $route->start_date;
		$addedFlight->save();

		$segment = $this->fixSegments($addedFlight->id, $reqeust->segments);
		$segmentRes = AddedFlightSegmentsController::call()
									->saveSegments($segment);

		return (object)[
										"vdr" => "cust",
										"vid" => $addedFlight->id,
										"sres" => $segmentRes, // segment's response
									];
	}



	public function fixSegments($vid, $segments)
	{
		$res = [];
		foreach ($segments as $segment) {
			$segment = (object) $segment;
			$departureDateTime = $this->fixDates($segment->departure);
			$arrivalDateTime = $this->fixDates($segment->arrival);
			
			$res[] = [
					"uid" => $segment->uid,
					"vsid" => $segment->vsid,
					"added_flight_id" => $vid,
					"name" => $segment->name,
					"code" => $segment->code,
					"number" => $segment->number,
					"origin_code" => $segment->origin_code,
					"destination_code" => $segment->destination_code,
					"departure_date_time" => $departureDateTime,
					"arrival_date_time" => $arrivalDateTime,
				];
		}

		return $res;
	}



	public function fixDates($date)
	{
		return Carbon::createFromFormat('Y/m/d H:i', $date)
										->toDateTimeString();
	}


	/*
	| this function for if flight is booked
	| id stand for the table id 
	| index for the result column array index like flight index 
	*/
	public function book($id)
	{
		$flight = $this->model()->find($id);
		$return = false;
		if (!is_null($flight)) {
			$return =  $flight->firstLastDateTime();
		}
		return $return;
	}


}
