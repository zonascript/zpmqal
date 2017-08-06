<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\CountryModel;


class CountryController extends Controller
{
	use CallTrait;
	
	public function model(){
		return new CountryModel;
	}

	public function getCountry($country = ''){
		return $this->model()->getCountry($country);
	}

}
