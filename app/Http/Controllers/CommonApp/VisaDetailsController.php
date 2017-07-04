<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\VisaDetailModel;

class VisaDetailsController extends Controller
{

	public static function call()
	{
		return new VisaDetailsController;
	}

	public function model()
	{
		return new VisaDetailModel;
	}
}
