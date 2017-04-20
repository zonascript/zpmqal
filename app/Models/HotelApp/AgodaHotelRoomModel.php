<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelRoomModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'agoda_hotel_rooms';

	public static function call()
	{
		return new AgodaHotelRoomModel;
	}

	public function findByHotelId($hotelId)
	{
		return $this->select(['id', 'roomtype', 'image'])
										->where(["hotel_id" => $hotelId])
											->get();
	}


	
	public function agodaHotel()
	{
		return $this->belongsTo(
											'App\Models\HotelApp\AgodaHotelModel', 
											'hotel_id', 'hotel_id'
										);
	}
}
