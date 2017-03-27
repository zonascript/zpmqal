<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mylibrary;

class TestController extends Controller
{
	public function getIndex(){
		$testclass = new Mylibrary\testclass();
		return $testclass->test();
    	// return json_encode(["Test" => "this is test for api"]);
    }
}
