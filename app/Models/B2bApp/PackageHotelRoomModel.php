<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageHotelRoomModel extends Model
{
	protected $table = 'package_hotel_rooms';
	protected $appends = ['room_id', 'room_type']; 

	public function call()
	{
		return new PackageHotelRoomModel;
	}

	public function getRoomIdAttribute()
	{
		return $this->roomtype_code;
	}

	public function getRoomTypeAttribute()
	{
		$result = '';
		if ($this->vendor == 'a') {
			$result = 'App\Models\HotelApp\AgodaHotelRoomModel';
		}
		elseif ($this->vendor == 'b') {
			$result = 'App\Models\HotelApp\BookingHotelRoomModel';
		}
		return $result;
	}

	public function room()
	{
		return $this->morphTo();
	}

}
