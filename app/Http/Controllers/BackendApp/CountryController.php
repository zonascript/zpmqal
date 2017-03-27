<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*===================================Models===================================*/
use App\Models\BackendApp\CountryModel;

class CountryController extends Controller
{
	public static function call(){
		return new CountryController;
	}

	public function model(){
		return new CountryModel;
	}

	public function getCountry($country = ''){
		return $this->model()->getCountry($search);
	}

	public function all(){
		return CountryModel::select()->where(['status' => 'Active'])->get();
	}

}
