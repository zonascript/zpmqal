<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ===============================Models===============================
use App\Models\Api\AgodaHotelDetailModel;

class AgodaHotelDetailsController extends Controller
{
	public static function call()
	{
		return new AgodaHotelDetailsController;
	}


	public function hotelDetail($hotelId)
	{
		$hotelDetail = $this->isExist($hotelId);
		$html = '';
		if (is_null($hotelDetail)) {
			$url = 'https://www.agoda.com/NewSite/en-us/Hotel/AboutHotel?hotelId='.$hotelId;
			$html = $this->httpGet($url);
			$hotelDetail = new AgodaHotelDetailModel;
			$hotelDetail->hotel_id = $hotelId;
			$hotelDetail->details = $html;
			$hotelDetail->save();
		}
		else{
			$html = $hotelDetail->details;
		}

		return $html;
	}

	/*
	| this function for checking route already exist 
	| or not behalf of route table id because one route 
	| can contain only one row in db
	*/
	public function isExist($hotelId)
	{
		$packageHotel = AgodaHotelDetailModel::select()
										->where(["hotel_id" => $hotelId])
											->first();

		return $packageHotel;
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
