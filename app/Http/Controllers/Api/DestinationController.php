<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*===================================Models===================================*/
use App\Models\Api\DestinationModel;

ini_set('max_execution_time', 3600);


class DestinationController extends Controller
{

	public static function call(){
		return new DestinationController;
	}


	// =================================returning model=================================

	public function model(){
		return new DestinationModel;
	}


	public function search($search){
		return $this->model()->search($search);
	}

	public function find($id){
		return $this->model()->self_find($id);
	}

	
	public function getLocation($search, $tags = null){
		return $this->model()->getLocation($search, $tags);
	}


	public function getLocationRight($search, $tags = null){
		return $this->model()->getLocationRight($search, $tags);
	}

  public function insert(){
    $recoveredData = file_get_contents('destinationList1.txt');
		$recoveredArrays = json_decode($recoveredData, true);
        
    $user = userdetail();
    

		foreach ($recoveredArrays as $destination_key => $destination_value) {
			if (isset($destination_value['City'])) {
				foreach ($destination_value['City'] as $destination_key1 => $destination_value1) {
    			
    			$destination = new Destination;

					$CityId = isset($destination_value1['CityId']) ? $destination_value1['CityId'] : '';
					$CityName = isset($destination_value1['CityName']) ? $destination_value1['CityName'] : '';
					$CountryCode = isset($destination_value1['CountryCode']) ? $destination_value1['CountryCode'] : '';
					$IsActive = isset($destination_value1['IsActive']) ? $destination_value1['IsActive'] : 0;

	        $destination->api 		=								'["tbtq"]';
	        $destination->status 		=							$IsActive;
	        $destination->statusby 		=						$user->username;
	        $destination->destination 	= 				$CityName;
					$destination->fgf_countrycode = 			$CountryCode;
					$destination->tbtq_countrycode 	=		 	$CountryCode;
	        $destination->fgf_destinationcode = 	$CityId;
	        $destination->tbtq_destinationcode 	= $CityId;

	        $destination->save();
				}
			}
		}
		// echo '<pre>'; print_r($recoveredArrays); echo '</pre>'; 
  }


}
