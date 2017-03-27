<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelDetailModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'agoda_hotel_details';

	public static function call()
	{
		return new AgodaHotelDetailModel;
	}
}
