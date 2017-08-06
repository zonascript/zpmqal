<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;

class BookingHotelRoomModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql4';
	protected $table = 'booking_hotel_rooms';
	protected $hidden = ['created_at', 'updated_at'];

	
	public function findByHotelId($bookingHotelId)
	{
		return $this->select(['id', 'roomtype'])
										->where(["booking_hotel_id" => $bookingHotelId])
											->groupBy('roomtype')
												->get();
	}


	public function bookingHotel()
	{
		return $this->belongsTo(
										'App\Models\HotelApp\BookingHotelModel',
										'booking_hotel_id', 'id');
	}

}
