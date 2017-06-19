<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HotelApp\BookingHotelController;
use pear\Services_JSON;
use App\Models\HotelApp\BookingHotelRoomModel;

class BookingHotelRoomsController extends Controller
{
	public $url = '';
	public $path = '';
	public $attmpt = 5;
	public $rooms = [];
	public $images = [];
	public $bookingHotel = null;
	public $bookingHotelId = null;

	public static function call()
	{
		return new BookingHotelRoomsController;
	}

	public function model()
	{
		return new BookingHotelRoomModel;
	}


	public function rooms($bookingHotelId)
	{
		$this->hotelRoom($bookingHotelId);
		return ['rooms' => $this->roomsWithImage(), 'images' => $this->images()];
	}

	public function roomsWithImage()
	{
		$rooms = [];
		$count = 0;
		if ($this->rooms->count()) {
			$images = $this->images();
			foreach ($this->rooms as $key => $room) {
				if ($key == count($images)) {
					$count = 0;
				}
				
				$image = $images[$count];
				$rooms[] = [
						'vdr' => 'b',
						'id' => $room->id,
						'roomtype' => $room->roomtype,
						'image' => $images[$count],
					];
				$count++;
			}
		}
		return $rooms;
	}


	public function images()
	{
		$images = [];

		if ($this->images->count()) {
			foreach ($this->images as $image) {
				$images[] = $image->thumb_url;
			}
		}
		else{
			$images[] = urlDefaultImageRoom();
		}
		return $images;
	}




	/*
	| finding hotel detail from db using agoda's hotel_id column 
	*/
	public function hotelRoom($bookingHotelId)
	{
		$this->bookingHotelId = $bookingHotelId;
		$result = $this->setBookingHotel()->fatchFromDb();
		if (!$this->bookingHotel->is_stored_room) {
			$result = $this->pullRooms();
		}
		return $result;
	}


	public function fatchFromDb($bookingHotelId = null)
	{
		$this->bookingHotelId = is_null($bookingHotelId) 
													? $this->bookingHotelId
													: $bookingHotelId;

		$rooms = '! invalid entry';
		
		if ($this->bookingHotelId) {
			$this->getDbRooms();
			$this->getDbImages();
		}

		$rooms = (object)['rooms' => $this->rooms, 'images' => $this->images];

		return $rooms;
	}



	public function pullRooms()
	{
		return $this->setBookingHotel()
									->getHttpRoomHtml()
										->extractRooms()
											->extractImages()
												->fatchFromDb();
	}


	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($hotelId)
	{
		return $this->model()->findByHotelId($hotelId);
	}


	public function getHttpRoomHtml()
	{
		$this->url = str_replace(
							'http://', 'https://', 
							$this->bookingHotel->hotel_url
						);

		$html = null;

		// taking five attmpt
		for ($i=0; $i < $this->attmpt; $i++) { 
			if (is_null($html) || $html == '' || strlen($html) < 1) {
				$html = $this->httpGet($this->url);
			}else{
				break;
			}
		}


		$path = 'mylocal/booking/html';
		if (!file_exists(storage_path($path))) {
			mkdir(storage_path($path), 0777);
		}

		$name = explode('/', $this->url);
		$name = str_replace('.html', '', end($name));
		$this->path = saveInStorage($html, $name, 'html', $path);
		$path  = str_replace(storage_path(), '', $this->path);
		// saving in db 
		$this->bookingHotel->is_stored_room = 1;
		$this->bookingHotel->stored_path = $path;
		$this->bookingHotel->save();
		return $this;
	}


	public function extractRooms()
	{
		$rooms = [];

		if (strlen($this->path)) {
			$this->fileExist();
			$content = trimHtml(file_get_contents($this->path));
			$dom = new \DOMDocument();
			$dom->recover = true;
			$dom->strictErrorChecking = false;
			$html = @$dom->loadHTML($content);
			$xpath = new \DomXPath($dom);
			$query = "//table//td[contains(@class, 'ftd')]";
	    $roomRows = $xpath->query($query);

	    foreach ($roomRows as $roomRow){
	      $rooms[] = trim($roomRow->nodeValue);
	    }
			$this->storeRooms($rooms);
			$this->getDbRooms();
		}

		return $this;
	}


	public function extractRoomsBySimpleHtmlDom()
	{
		include_once app_path('MyLibrary/simple_html_dom.php');
		
		$rooms = [];

		if (strlen($this->path)) {
			$this->fileExist();
			$html = file_get_html($this->path);
			foreach ($html->find('td[class=ftd]') as $tdText) {
				$room = trim($tdText->plaintext);
				$rooms[] = $room;
			}

			$this->storeRooms($rooms);
			$this->getDbRooms();
		}

		return $this;
	}




	public function storeRooms(Array $rooms, $hotelId = null)
	{
		$hotelId = is_null($hotelId) ? $this->bookingHotelId : $hotelId;
		if (is_array($rooms)) {
			$rooms =  array_unique($rooms);
			foreach ($rooms as &$room) {
				$room = [
						"roomtype" => $room,
						"booking_hotel_id" => $hotelId,
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s'),
					];
			}
		}
		return BookingHotelRoomModel::insert($rooms);
	}


	public function extractImages()
	{
		if (strlen($this->path)) {
			$this->fileExist();
			$html = file_get_contents($this->path);
			preg_match_all("/hotelPhotos\s*:\s*\[.*?\],/s", $html, $matches);
			$images = [];
			if (isset($matches[0][0])) {
				$images = $matches[0][0];
				$images = ltrim($images,"hotelPhotos: ");
				$images = rtrim($images,",");
				$images = fixjson($images);
				$images = json_decode($images);
			}

			$this->storeImages($images);
			$this->getDbImages();
		}
		return $this;
	}


	public function storeImages(Array $images, $hotelId = null)
	{
		$hotelId = is_null($hotelId) ? $this->bookingHotelId : $hotelId;
		if (is_array($images)) {

			foreach ($images as &$image) {
				$image = [
						"bimgid" => $image->id,
						"booking_hotel_id" => $hotelId,
						"thumb_url" => $image->thumb_url,
						"large_url" => $image->large_url,
						"created_at" => date('Y-m-d H:i:s'),
						"updated_at" => date('Y-m-d H:i:s'),
					];
			}
		}
		return BookingHotelImagesController::call()->model()->insert($images);
	}


	public function getDbImages()
	{
		$this->images = BookingHotelImagesController::call()
							->model()->findByHotelId($this->bookingHotelId);
		if (!$this->images->count()) {
			$this->setPath();
			$this->extractImages();
		}

		return $this;
	}


	public function getDbRooms()
	{
		$this->rooms = $this->isExist($this->bookingHotelId);

		if (!$this->rooms->count()) {
			$this->setPath();
			$this->extractRooms();
		}

		return $this;
	}

	public function fileExist()
	{
		if (!file_exists($this->path)) {
			$this->getHttpRoomHtml();
		}
		return $this;
	}


	public function setPath($path = null)
	{
		$this->path = $path;
		if (is_null($path)) {
			$this->setBookingHotel();

			if ($this->bookingHotel->is_stored_room && strlen($this->bookingHotel->stored_path)) {

				$this->path = findWord(storage_path(),$this->bookingHotel->stored_path) 
										? $this->bookingHotel->stored_path
										: storage_path($this->bookingHotel->stored_path);
			}
		}

		$this->path = str_replace('//', '/', $this->path);
		return $this;
	}


	public function setBookingHotel($bookingHotelId = null)
	{
		$this->bookingHotelId = is_null($bookingHotelId) 
													? $this->bookingHotelId
													: $bookingHotelId;
		if (!isset($this->bookingHotel->id) && $this->bookingHotelId) {
			$this->bookingHotel = BookingHotelsController::call()
														->model()->find($this->bookingHotelId);	
		}

		return $this;
	}


	public function httpGet($url){
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}

}
