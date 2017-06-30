<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\FlightApp\AddedFlightSegmentModel;


class AddedFlightModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'added_flights';

	public function segments()
	{
		$s = $this->hasMany(AddedFlightSegmentModel::class, 'added_flight_id');
		return $s->where(['is_active' => 1]);
	}

	public function firstLastDateTime()
	{
		$result = (object) [];
		if ($this->segments->count()) {
			$startDate = $this->segments->first()->departure();
			$endDate = $this->segments->last()->arrival();
			$result = (object)[
					"startDateTime" => (object) [
									'date' => $startDate->format('Y-m-d'),
									'time' => $startDate->format('H:i'),
								],
					"endDateTime" => (object) [
									'date' => $endDate->format('Y-m-d'),
									'time' => $endDate->format('H:i'),
								],
					"vendor" => 'cust',
				];
		}

		return $result;
	}

	public function flightDetail()
	{
		$flightDetails = [];
		foreach ($this->segments as $segment) {
			$flightDetails[] = $segment->detail();
		}
		return $flightDetails;
	}
}
