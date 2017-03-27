<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class AgodaHotelImageModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'agoda_hotel_images';
}
