<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;

class QpxFlightModel extends Model
{
	protected $table = 'qpx_flights';
	protected $appends = ['airlines', 'cities', 'slices', 'legs', 'segments'];
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

		$qpxFlight = $this->result_object;

		$tripOption = null;
		if (isset($qpxFlight->trips->tripOption[$this->selected_index])) {
			$tripOption = $qpxFlight->trips->tripOption[$this->selected_index];
		}


		$stops = [];
		$timings = [];
		$carriers = [];

		$loopCount = 1;

		foreach ($tripOption->slice as $slice) {
			foreach ($slice->segment as $segment) {
				$carrierCode = ifset($segment->flight->carrier);
				$carrierNumber = ifset($segment->flight->number);
				$carrierName = ifset($this->airlines->$carrierCode);
				$carriers[$carrierCode]['name'] = $carrierName;
				$carriers[$carrierCode]['codeNumber'][] = $carrierCode.$carrierNumber;

				foreach ($segment->leg as $leg) {
					$origin = $leg->origin;
					$destination = $leg->destination;
					
					if ($loopCount == 1) {
						$stops[] = ['cityCode' => $origin, "city" => ifset($this->cities->$origin)];
						$stops[] = [
								"cityCode" => $destination, 
								"city" => ifset($this->cities->$destination)
							];
					}
					else{
						$stops[] = [
								"cityCode" => $destination, 
								"city" => ifset($this->cities->$destination)
							];
					}
					$loopCount++;

					$departureDateTime = getDateTime($leg->departureTime);
					$arrivalDateTime = getDateTime($leg->arrivalTime);
					
					$timings[] = [
							"departureDateTime" => $departureDateTime,
							"arrivalDateTime"		=> $arrivalDateTime
						];
				}
			}
		}


		$result = [
				"stops" => $stops,
				"timings" => $timings,
				"carriers" => $carriers
			];

		return rejson_decode($result);

	}



	public function __construct()
	{
		parent::__construct();
		DB::statement('SET wait_timeout=1200;');
	}

}
