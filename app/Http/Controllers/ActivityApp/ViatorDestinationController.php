<?php

namespace App\Http\Controllers\ActivityApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ==============================Models==============================
use App\Models\ActivityApp\ViatorDestinationModel;



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
