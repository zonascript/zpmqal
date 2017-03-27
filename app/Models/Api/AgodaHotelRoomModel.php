<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelRoomModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'agoda_hotel_rooms';

	public static function call()
	{
		return new AgodaHotelRoomModel;
	}
}
