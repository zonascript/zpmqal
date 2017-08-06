<?php

namespace App\Http\Controllers\FlightApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FlightApp\AddedFlightSegmentModel;
use App\Traits\CallTrait;

class AddedFlightSegmentsController extends Controller
{
	use CallTrait;


	public function model()
	{
		return new AddedFlightSegmentModel;
	}


	public function saveSegments($segments)
	{
		$res = [];
		foreach ($segments as $key => $segment) {
			$segment = (object) $segment;

			$addSegment = null;
			if (isset($segment->vsid)) {
				$addSegment = $this->model()->find($segment->vsid);
			}

			if (is_null($addSegment)) {
				$addSegment = $this->model();
			}

			$addSegment->added_flight_id = $segment->added_flight_id;
			$addSegment->name = $segment->name;
			$addSegment->code = $segment->code;
			$addSegment->number = $segment->number;
			$addSegment->origin_code = $segment->origin_code;
			$addSegment->destination_code = $segment->destination_code;
			$addSegment->departure_date_time = $segment->departure_date_time;
			$addSegment->arrival_date_time = $segment->arrival_date_time;
			$addSegment->save();
			$res[$segment->uid] = $addSegment->id;
		}
		
		return $res;

	}



}


