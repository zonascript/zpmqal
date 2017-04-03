<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==========================Api Controller==========================
use App\Http\Controllers\Api\AgodaHotelsController;
use App\Http\Controllers\Api\AgodaHotelImagesController;
use App\Http\Controllers\Api\AgodaHotelDetailsController;

// ==============================Models==============================
use App\Models\Api\AgodaHotelRoomModel;

class AgodaHotelRoomsController extends Controller
{
	public static function call()
	{
		return new AgodaHotelRoomsController;
	}

	/*
	| finding hotel detail from db using agoda's hotel_id column 
	*/
	public function hotelRoom($agodaHotelId)
	{
		$rooms = $this->fatchFromDb($agodaHotelId);
		if (!$rooms->rooms->count()) {
			$agodaHotel = AgodaHotelsController::call()
										->model()->call()->hotelByAgodaId($agodaHotelId);

			$url = 'https://www.agoda.com'.$agodaHotel->url;
			$rooms = $this->extractRoomDetails($url,true);
			$this->storeRooms($rooms->rooms, $agodaHotelId);
			AgodaHotelImagesController::call()->bulkInsert($rooms->images, $agodaHotelId);

			$rooms = $this->fatchFromDb($agodaHotelId);
		}
		
		// $hotelDetail = AgodaHotelDetailsController::call()->hotelDetail($agodaHotelId);
		// $hotelDetail = trimHtml($hotelDetail);
		// $rooms->details = $hotelDetail;

		return rejson_decode($rooms);
	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($hotelId)
	{
		$packageHotel = AgodaHotelRoomModel::select(['id', 'roomtype', 'image'])
										->where(["hotel_id" => $hotelId])
											->get();

		return $packageHotel;
	}

	public function fatchFromDb($agodaHotelId)
	{
		$rooms = (object)['rooms' => '', 'images' => ''];
		$rooms->rooms = $this->isExist($agodaHotelId);
		$rooms->images = AgodaHotelImagesController::call()->hotelImages($agodaHotelId);
		return $rooms;
	}

	public function getHttpRoomHtml($url, $attmpt = 5)
	{
		$html = null;

		if ($attmpt) {
			$html = $this->httpGet($url);
			if (is_null($html) || $html == '') {
				$attmpt = $attmpt-1;
				$html = $this->getHttpRoomHtml($url, $attmpt);
			}
		}

		if (!file_exists(storage_path('mylocal/agoda'))) {
			mkdir(storage_path('mylocal/agoda'), 0777);
		}

		$filePath = saveInStorage($html, 'agoda_rooms', 'html', 'mylocal/agoda');

		return (object)["html" => $html, "filePath" => $filePath];
	}


	public function extractImages($html)
	{
		preg_match_all("/images\s*:\s*\[.*?\],/s", $html, $matches);

		$images = [];
		if (isset($matches[0][0])) {
			$images = $matches[0][0];
			$images = ltrim($images,"images: ");
			$images = rtrim($images,",");
			$images = json_decode($images);
		}
		return $images;
	}


	public function extractRoomDetails($filePath, $isUrl = false, $attmpt = 5)
	{
		$result = [];
		$rooms = [];
		if ($attmpt) {

			if ($isUrl) {
				$filePath = $this->getHttpRoomHtml($filePath);
			}
			
			include_once app_path('MyLibrary/simple_html_dom.php');
			$rawHtml = $filePath->html;
			$html = file_get_html($filePath->filePath);
			$titleObj = $html->find('title', 0);
			$title = isset($titleObj->plaintext) ? $titleObj->plaintext : '';
			if (findWord('Object moved', $title)) {
				$newUrlObj = $html->find('a', 0);
				$newUrl = $newUrlObj->href;
				$attmpt = $attmpt-1;
				$result = $this->extractRoomDetails($newUrl, true, $attmpt);
			}
			else{
				foreach($html->find('tr') as $row) {
			    $tdTexts = $row->find('td[class=room_col]',0);
			    if (!is_null($tdTexts)) {
				    $roomtypeObj = $tdTexts->find('span', 0);
				    $roomtype = '';
						if(isset($roomtypeObj->plaintext)){
			    		$roomtype = $roomtypeObj->plaintext;
						}


						$imgObj = $tdTexts->find('img', 0);
				    $img = '';
						if(isset($imgObj->src)){
			    		$img = $imgObj->src ;
						}

			   		$rooms[] = ['roomtype' => $roomtype, 'image' => $img];
			    }
				}
				$images = $this->extractImages($rawHtml);

				$result = (object)["rooms" => $rooms, "images" => $images];
			}
		}	

		return $result;
	}


	public function storeRooms($rooms, $hotelId)
	{
		if (is_array($rooms)) {
			foreach ($rooms as &$room) {
				$room['hotel_id'] = $hotelId;
				$room['created_at'] = date('Y-m-d H:i:s');
				$room['updated_at'] = date('Y-m-d H:i:s');
			}
		}

		return AgodaHotelRoomModel::insert($rooms);
	}


	public function httpGet($url)
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYPEER=> false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		return $response;
	}


}
