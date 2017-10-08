<?php

namespace App\Http\Controllers\HotelApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelApp\TbtqTokenModel;
use App\Traits\HotelApp\TbtqHotelTrait;
use App\Traits\CallTrait;

class TbtqTokenController extends Controller
{
	use CallTrait, TbtqHotelTrait;

	public $url = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/Authenticate';

	public $balUrl = 'http://api.tektravels.com/SharedServices/SharedData.svc/rest/GetAgencyBalance';

	public $requestAuth;


	public function token()
	{
		$token = TbtqTokenModel::byExpireAt()
						->orderBy('created_at', 'desc')->first();

		return is_null($token) ? $this->authenticate() : $token;
	}

	public function checkBalance()
	{

		$token = $this->token();
		$req = $token->makeGetAgencyBalance();
		$json = $this->httpPost($this->balUrl, $req);
		dd(json_encode($req), $json);

	}


	// this is the parameter array for auth
	public function getHideRequestAuth()
	{
		return array_merge($this->requestAuth, [
				"UserName" => 'XXXXXXXX',
				"Password" => 'XXXXXXXX',
			]);
	}



	/*
	| this function for getting token from tbtq
	*/
	public function authenticate(){
		$json = $this->httpPost($this->url, $this->requestAuth);
		$response = json_decode($json);
		$token = new TbtqTokenModel; 
		$token->request = $this->getHideRequestAuth();
		$token->response = $response;
		$token->save();
		return $token;
	}


	function __construct()
	{
		$this->requestAuth = [
				"ClientId" => env('TBTQ_HOTEL_CLIENTID'),
				"UserName" => env('TBTQ_HOTEL_USERNAME'),
				"Password" => env('TBTQ_HOTEL_PASSWORD'),
				"EndUserIp" => $_SERVER['REMOTE_ADDR']
			];
	}


}
