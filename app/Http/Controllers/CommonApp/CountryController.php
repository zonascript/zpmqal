<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*===================================Models===================================*/
use App\Models\CommonApp\CountryModel;


class CountryController extends Controller
{
	public static function call(){
		return new CountryController;
	}

	public function model(){
		return new CountryModel;
	}

	public function getCountry($country = ''){
		return $this->model()->getCountry($country);
	}

}
