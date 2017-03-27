<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SkyscannerFlightsModel extends Model
{
	protected $table = 'skyscanner_flights';
	protected $appends = [
			'places_formatted', 
			'carriers_formatted',
			'leg', 'segments'
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

}