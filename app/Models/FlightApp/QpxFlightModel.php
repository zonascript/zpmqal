<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class QpxFlightModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'qpx_flights';
	protected $appends = [
			'airlines', 'cities', 'slices', 'legs', 'segments',
			'departureDateTime', 'arrivalDateTime'
		];
		
	protected $casts = [
			'request' => 'object', 
			'result' => 'object'
		];


	/*======================this function to get all airline code======================*/

	public function getAirlinesAttribute(){
		$airlineCode = [];
		foreach ($this->result->trips->data->carrier as $airline) {
			$airlineCode[$airline->code] = $airline->name;
		}
		return (object) $airlineCode;
	}


	/*===================this function for making index by city code===================*/
	public function getCitiesAttribute(){
		$cityCode = [];
		foreach ($this->result->trips->data->city as $city) {
			$cityCode[$city->code] = $city->name;
		}
		return (object) $cityCode;
	}



	public function getDepartureDateTimeAttribute()
	{
		$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];
		if (isset($this->slices[0]->segment[0]->leg[0]->departureTime)) {
			$departureDateTime = Carbon::parse($this->slices[0]
																	 ->segment[0]->leg[0]
																		 ->departureTime);
			$dateTime->date = $departureDateTime->format('Y-m-d');
			$dateTime->time = $departureDateTime->format('H:i');
		}

		return $dateTime;
	}


	public function getArrivalDateTimeAttribute()
	{
		$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];

		$sliceCount = count($this->slices)-1;
		if (isset($this->slices[$sliceCount]->segment)) {
			$segmentCount = count($this->slices[$sliceCount]->segment)-1;

			if (isset($this->slices[$sliceCount]->segment[$segmentCount]->leg)) {
				$legCount = count($this->slices[$sliceCount]
																 ->segment[$segmentCount]->leg)-1;

				// finding end Date here
				$arrivalDateTime = Carbon::parse($this->slices[$sliceCount]
													->segment[$segmentCount]->leg[$legCount]
														->arrivalTime);

				$dateTime->date = $arrivalDateTime->format('Y-m-d');
				$dateTime->time = $arrivalDateTime->format('H:i');
			}
		}

		return $dateTime;
	}



	public function getSlicesAttribute()
	{
		$result = $this->result;
		return $result->trips->tripOption[$this->selected_index]->slice;
	}


	public function getSegmentsAttribute()
	{
		$slices = $this->slices;
		$cities = $this->cities;
		$airlines = $this->airlines;
		$segments = [];
		foreach ($slices as $slice) {
			foreach ($slice->segment as  $segment) {
				$carrier = $segment->flight->carrier;
				$airlineDetail = $segment->flight;
				$airlineDetail->name = $airlines->$carrier;
				foreach ($segment->leg as $leg) {
					$tempLeg = $leg;
					$tempLeg->airline = $airlineDetail;
					$tempLeg->departureDateTime = getDateTime($leg->departureTime);
					$tempLeg->arrivalDateTime = getDateTime($leg->arrivalTime);

					$originCode = $leg->origin;
					$tempLeg->originCity = isset($cities->$originCode) 
															 ? $cities->$originCode
															 : $originCode;

					$destinationCode = $leg->destination;
					$tempLeg->destinationCity = isset($cities->$destinationCode)
															 ? $cities->$destinationCode
															 : $destinationCode;
					$segments[] = $tempLeg;
				}
			}
		}
		return $segments; 
	}


	public function flightDetail()
	{
		$slices = $this->slices;
		$cities = $this->cities;
		$airlines = $this->airlines;
		$flightDetails = [];
		foreach ($slices as $slice) {
			foreach ($slice->segment as  $segment) {
				$carrier = $segment->flight->carrier;
				
				$flightDetail = (object)[
						"name" => $airlines->$carrier,
						"code" => $segment->flight->carrier,
						"flightNumber" => $segment->flight->number,
						"departureTime" => '',
						"departureDate" => '',
						"arrivalTime" => '',
						"arrivalDate" => '',
						"origin" => '',
						"originCode" => '',
						"destination" => '',
						"destinationCode" => ''
					];

				foreach ($segment->leg as $leg) {
					$departureDateTime = getDateTime($leg->departureTime);
					$arrivalDateTime = getDateTime($leg->arrivalTime);

					$flightDetail->departureDate = $departureDateTime->date;
					$flightDetail->departureTime = $departureDateTime->time;
					
					$flightDetail->arrivalDate = $arrivalDateTime->date;
					$flightDetail->arrivalTime = $arrivalDateTime->time;

					$originCode = $leg->origin;
					$flightDetail->originCode = $originCode;
					$flightDetail->origin = isset($cities->$originCode) 
																? $cities->$originCode
																: $originCode;

					$destinationCode = $leg->destination;
					$flightDetail->destinationCode = $destinationCode;
					$flightDetail->destination = isset($cities->$destinationCode)
																		 ? $cities->$destinationCode
																		 : $destinationCode;
				}

				$flightDetails[] = $flightDetail;
			}
		}
		return $flightDetails;
	}

	public function tripOption()
	{
		return $this->result->trips->tripOption[$this->selected_index];
	}


	public function __construct()
	{
		parent::__construct();
		DB::statement('SET wait_timeout=1200;');
	}

}
