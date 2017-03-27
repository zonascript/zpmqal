<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// using models here
use App\Models\Api\ActivityModel;

class ActivityController extends Controller
{
	public static function call(){
		return new ActivityController;
	}

  public function getActivities($cityId, $date){
		return ActivityModel::call()->getActivities($cityId, $date);
  }

  public function all(){
  	$result = ActivityModel::all(['id', 'countryCode','name']);
  }

  public function model()
  {
  	return new ActivityModel;
  }

}
