<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==============================Models==============================
use App\Models\Api\ViatorDestinationModel;



class ViatorDestinationController extends Controller
{
	public static function call()
	{
		return new ViatorDestinationController;
	}

	public function searchDestination($serach='')
	{
		$result = ViatorDestinationModel::call()->searchDestiantion($serach);
		return $result;
	}
}
