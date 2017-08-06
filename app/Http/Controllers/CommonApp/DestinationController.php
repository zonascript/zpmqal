<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\DestinationModel;
use App\Traits\CallTrait;

class DestinationController extends Controller
{
	use CallTrait;

	public function model(){
		return new DestinationModel;
	}


	public function getDestination(Request $request){
		$tag = $request->tags;
		$locations = $this->model()->getLocationRight($request->term, $tag);
		if (!$locations->count()) {
			$locations = $this->model()->getLocation($request->term, $tag);
		}

		$result = [];
		foreach ($locations as $location) {
			$result[] = $location->location;
		}

		return json_encode($result);
	}


	public function names(Request $request){
		$tag = $request->tags;
		$locations = $this->model()->getLocationRight($request->term, $tag);
		if (!$locations->count()) {
			$locations = $this->model()->getLocation($request->term, $tag);
		}

		$result = [];
		foreach ($locations as $location) {
			$result[] = [
											'name' => $location->location,
											'code' => $location->id
										];
		}

		return json_encode($result);
	}


	public function getCountry(){
		$locations = CountryController::call()->getCountry();
		$country_array = [];

		if(bool_array($locations)){
			foreach ($locations as $location) {
				$country_array[] = $location->CountryCode;
			}
		}

		return json_encode($country_array);
	}


}
