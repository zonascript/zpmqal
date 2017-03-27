<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\FgfApiController;
use App\Http\Controllers\Api\TbtqApiController;


class GlobalApiController extends Controller
{
    public function getHotelResult($array){
    	
    	// array = ['TbtqHotelResults', 'FgfHotelResults']; will be like this

    	$result = [];

			if (isset($array['TbtqHotelResults']) && bool_array($array['TbtqHotelResults'])) {
				$TbtqApiController_obj = new TbtqApiController();
				foreach ($array['TbtqHotelResults'] as $TbtqHotelResults_key => $TbtqHotelResults_value) {
					$result[] = $TbtqApiController_obj->globalHotelResult($TbtqHotelResults_value,$TbtqHotelResults_key); 
				}
			};

			if (isset($array['FgfHotelResults']) && bool_array($array['FgfHotelResults'])) {
				$FgfApiController_obj = new FgfApiController();
				foreach ($array['FgfHotelResults'] as $FgfHotelResults_key => $FgfHotelResults_value) {
					$result[] = $FgfApiController_obj->globalHotelResult($FgfHotelResults_value,$FgfHotelResults_key); 
				}
			};

			return $this->mergeHotelResult($result);
    }
    

    public function mergeHotelResult($array){

    	if (count($array) == 1) {
    		return isset($array[0]) ? $array[0] : false;
    	}
    	elseif (count($array) > 1) {
    		$singleArray = [];
    		foreach ($array as $key => $value) {
    			$singleArray[$value['HotelCode']][] = $value;
    		}

    		$result = [];
    		foreach ($singleArray as $singleArray_key => $singleArray_value) {
    			if (count($array) == count($singleArray_value)) {
    				$count = 1;
    				$roomResult = [];
    				foreach ($singleArray_value as $singleArray_key1 => $singleArray_value1) {
    					if ($count = 1) {
    						$roomResult = $singleArray_value1;
    					}else{
    						$roomResult["ApiRequest"][] = $singleArray_value1["ApiRequest"];
    						$roomResult["Price"] += $singleArray_value1["Price"];
    					}
    					$count++;
    				}

    				$result[] = $roomResult;
    			}
    		}

    		return $result;
    	}
    	else{
    		return false;
    	}
    }

    public function getHotelRoom($array){
    	
    	// array = ['TbtqHotelResults', 'FgfHotelResults']; will be like this

    	$result = [];

			if (isset($array['TbtqHotelRoom']) && bool_array($array['TbtqHotelRoom'])) {
				$TbtqApiController_obj = new TbtqApiController();
				foreach ($array['TbtqHotelRoom'] as $TbtqHotelResults_key => $TbtqHotelResults_value) {
					$result[] = $TbtqApiController_obj->globalHotelRoom($TbtqHotelResults_value,$TbtqHotelResults_key); 
				}
			};

			if (isset($array['FgfHotelRoom']) && bool_array($array['FgfHotelRoom'])) {
				$FgfApiController_obj = new FgfApiController();
				foreach ($array['FgfHotelRoom'] as $FgfHotelResults_key => $FgfHotelResults_value) {
					$result[] = $FgfApiController_obj->globalHotelRoom($FgfHotelResults_value,$FgfHotelResults_key); 
				}
			};

			return $this->mergeHotelResult($result);
    }

    public function mergeHotelRoom($array){

    	if (count($array) == 1) {
    		return $array;
    	}
    	elseif (count($array) > 1) {
    		/*
    		|--------------this time returned false here -------------------
    		|*/

    		// $singleArray = [];
    		// foreach ($array as $key => $value) {
    		// 	$singleArray[$value['HotelCode']][] = $value;
    		// }

    		// $result = [];
    		// foreach ($singleArray as $singleArray_key => $singleArray_value) {
    		// 	if (count($array) == count($singleArray_value)) {
    		// 		$count = 1;
    		// 		$roomResult = [];
    		// 		foreach ($singleArray_value as $singleArray_key1 => $singleArray_value1) {
    		// 			if ($count = 1) {
    		// 				$roomResult = $singleArray_value1;
    		// 			}else{
    		// 				$roomResult["ApiRequest"][] = $singleArray_value1["ApiRequest"];
    		// 				$roomResult["Price"] += $singleArray_value1["Price"];
    		// 			}
    		// 			$count++;
    		// 		}

    		// 		$result[] = $roomResult;
    		// 	}
    		// }

    		return false;
    	}
    	else{
    		return false;
    	}
    }
}
