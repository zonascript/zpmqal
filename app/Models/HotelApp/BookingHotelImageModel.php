<?php

namespace App\Models\HotelApp;

use Illuminate\Database\Eloquent\Model;

class BookingHotelImageModel extends Model
{
	protected $connection = 'mysql4';
	protected $table = 'booking_hotel_images';
	protected $hidden = ['created_at', 'updated_at'];

	public static function call()
	{
		return new BookingHotelImageModel;
	}

	public function findByHotelId($hotelId)
	{
		return $this->select(['thumb_url', 'large_url'])
									->where(['booking_hotel_id' => $hotelId])
										->get();
	}


	public function images($hotelId)
	{
		$images = [];
		$data = $this->findByHotelId($hotelId);
		
		foreach ($data as $image) {
			$images[] = $image->thumb_url;
		}

		return array_values(array_unique($images));
	}

}
