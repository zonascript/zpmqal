<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ====================================Models====================================
use App\Models\Api\CruisePriceModel;

class CruisePriceController extends Controller
{
	public static function call()
	{
		return new CruisePriceController;
	}

	public function model()
	{
		return new CruisePriceModel;
	}

	public function cruise($params)
	{
		return $this->model()->pullCruise($params);
	}

	public function cruiseCabin($params)
	{
		return $this->model()->pullCruiseCabin($params);
	}

}
