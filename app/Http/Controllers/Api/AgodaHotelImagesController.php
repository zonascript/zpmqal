<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===========================Models===========================
use App\Models\Api\AgodaHotelImageModel;

class AgodaHotelImagesController extends Controller
{
	public static function call()
	{
		return new AgodaHotelImagesController;
	}

	public function bulkInsert($images, $hotelId)
	{
		$images = rejson_decode($images, true);
		$dbImages = $this->hotelImages($hotelId);
		if (is_array($images) && $dbImages->count() != count($images)) {
			foreach ($images as &$image) {
				$image['hotel_id'] = $hotelId;
				$image['aid'] = $image['Id'];
				$image['created_at'] = date('Y-m-d H:i:s');
				$image['updated_at'] = date('Y-m-d H:i:s');
				unset($image['Id']);
			}
			return AgodaHotelImageModel::insert($images);
		}else{
			return $dbImages;
		}

	}


	public function hotelImages($hotelId)
	{
		$images = AgodaHotelImageModel::select([
										'id', 'aid', 'Title', 'Location', 'LocationWithWideSize',
										'LocationWithSquareSize', 'LocationWithSquareSize2X',
										'Group', 'IsRoomImage'
									])
								->where(['hotel_id' => $hotelId])
									->get();
									
		return $images;

	}

}
