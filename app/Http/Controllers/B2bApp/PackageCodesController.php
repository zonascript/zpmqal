<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\B2bApp\PackageCodeModel;

class PackageCodesController extends Controller
{
	public static function call()
	{
		return new PackageCodesController;
	}
	
	public function model()
	{
		return new PackageCodeModel;
	}

}
