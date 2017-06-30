<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\AirportModel;
use App\Models\FlightApp\AddedFlightModel;
use Carbon\Carbon;


class AddedFlightSegmentModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'added_flight_segments';
	protected $appends = ['origin', 'destination'];

	public function trip()
	{
		$this->hasMany(AddedFlightModel::class, 'added_flight_id');
	}


	public function originAirport()
	{
		return $this->belongsTo(
											AirportModel::class, 
											'origin_code',
											'airport_code'
										);
	}


	public function destinationAirport()
	{
		return $this->belongsTo(
											AirportModel::class, 
											'destination_code',
											'airport_code'
										);
	}



	public function getOriginAttribute()
	{
		$name = $this->origin_code;

		if (!is_null($this->originAirport)) {
			$name = $this->originAirport->city.', '
							.$this->originAirport->country;
		}

		return $name;
	}

	

	public function getDestinationAttribute()
	{
		$name = $this->destination_code;

		if (!is_null($this->destinationAirport)) {
			$name = $this->destinationAirport->city.', '
							.$this->destinationAirport->country;
		}

		return $name;
	}



	public function departure()
	{
		return Carbon::parse($this->departure_date_time);
	}


	public function arrival()
	{
		return Carbon::parse($this->arrival_date_time);
	}


	public function removeSegment($id)
	{
		$result = false;
		$segment = $this->find($id);
		if (!is_null($segment)) {
			$segment->is_active = 0;
			$segment->save();
			$result = true;
		}
		return $result;
	}


	public function detail()
	{
		return (object)[
					"name" => $this->name,
					"code" => $this->code,
					"flightNumber" => $this->number,
					"departureTime" => $this->departure()->format('h:i'),
					"departureDate" => $this->departure()->format('Y-m-d'),
					"arrivalTime" => $this->departure()->format('h:i'),
					"arrivalDate" => $this->departure()->format('Y-m-d'),
					"origin" => $this->origin,
					"originCode" => $this->origin_code,
					"destination" => $this->destination,
					"destinationCode" => $this->destination_code
				];
	}

}
