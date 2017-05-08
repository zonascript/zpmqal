<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*===================================Models===================================*/
use App\Models\CommonApp\DestinationModel;

class DestinationController extends Controller
{

	public static function call(){
		return new DestinationController;
	}


	public function model(){
		return new DestinationModel;
	}



}
