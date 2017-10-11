<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class PackageHotelRoomModel extends Model
{
	use CallTrait;

	protected $table = 'package_hotel_rooms';
	protected $appends = ['room_id', 'room_type']; 

	public function getRoomIdAttribute()
	{
		return $this->roomtype_code;
	}

	public function getRoomTypeAttribute()
	{
		return $this->getRelatedModelNames($this->vendor);
	}


	public function getRelatedModelNames($vendor='')
	{
		$models = [
				'a' 	=> 'App\Models\HotelApp\AgodaHotelRoomModel',
				'b' 	=> 'App\Models\HotelApp\BookingHotelRoomModel',
				'own' => 'App\Models\HotelApp\OwnHotelRoomModel'
			];

		return isset($this->models[$vendor])
				 ? $this->models[$vendor]
				 : '';
	}

	public function room()
	{
		return $this->morphTo();
	}

}
