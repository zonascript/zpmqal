<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SkyscannerFlightsModel extends Model
{
	protected $table = 'skyscanner_flights';
	protected $appends = [
			'places_formatted', 
			'carriers_formatted',
			'leg', 'segments',
			'departureDateTime',
			'arrivalDateTime'
		];
	protected $casts = [
			'request' => 'object',
			'result' => 'object'
		];



	public function getPlacesFormattedAttribute()
	{
		$places = [];
		
		if (isset($this->result->Places)) {
			foreach ($this->result->Places as $place) {
				$places[$place->Id] = $place;
			}
		}

		return $places;
	}


	public function getCarriersFormattedAttribute()
	{
		$carriers = [];
		
		if (isset($this->result->Carriers)) {
			foreach ($this->result->Carriers as $carrier) {
				$carriers[$carrier->Id] = $carrier;
			}
		}

		return $carriers;
	}


	public function getLegAttribute()
	{
		$result = $this->result;
		$index = $this->selected_index;
		$leg  = false;
		if (isset($result->Legs[$this->selected_index])) {
			$leg = $result->Legs[$this->selected_index];
		}
		return $leg;
	}


	public function getSegmentsAttribute()
	{
		$leg = $this->leg;
		$segmentIds = $leg->SegmentIds;
		$result = $this->result;
		$result->Segments;

		$segments = [];
		$segment = '';
		foreach ($segmentIds as $segmentId) {
			$segment = $result->Segments[$segmentId];
			$segment->DepartureTiming = getDateTime($segment->DepartureDateTime);
			$segment->ArrivalTiming = getDateTime($segment->ArrivalDateTime);
			$segment->Origin = $this->places_formatted[$segment->OriginStation]; 
			$segment->Destination = $this->places_formatted[$segment->DestinationStation];
			$segment->CarrierDetail = $this->carriers_formatted[$segment->Carrier];
			$segments[] = $segment;
		}

		return $segments; 
	}


	// public function getDepartureDateTimeAttribute(){
	// 	$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];
	// 	$check = (
	// 			isset($this->leg->SegmentIds) && 
	// 			isset($this->result->Segments[$segmentIds[0]]->DepartureDateTime)
	// 		);

	// 	if ($check) {
	// 		$segmentIds = $this->leg->SegmentIds;
	// 		$departureDateTime = Carbon::parse($this->result
	// 																	->Segments[$segmentIds[0]]
	// 																		->DepartureDateTime);
	// 		$dateTime->date = $departureDateTime->format('Y-m-d');
	// 		$dateTime->time = $departureDateTime->format('H:i');
	// 	}

	// 	return $dateTime;		
	// }


	// public function getArrivalDateTimeAttribute(){
	// 	$dateTime = (object)['date' => '0000-00-00', 'time' => '00:00'];

	// 	$check = (
	// 			isset($this->leg->SegmentIds) && 
	// 			isset(
	// 					$this->result
	// 								->Segments[count((array)$segmentIds)-1]
	// 									->DepartureDateTime
	// 				)
	// 		);

	// 	$endDate = $flightDetail->Segments[]->ArrivalDateTime;
	// 	$endDate = str_replace('T', ' ', $endDate);
	// }

}