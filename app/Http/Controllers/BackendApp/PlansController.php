<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackendApp\PlanModel;


class PlansController extends Controller
{

	public static function call()
	{
		return new PlansController;
	}

	public function model()
	{
		return new PlanModel;
	}

}
