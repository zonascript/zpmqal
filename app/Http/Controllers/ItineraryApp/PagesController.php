<?php

namespace App\Http\Controllers\ItineraryApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonApp\UrlController;
use App\Http\Controllers\B2bApp\PackageController;

class PagesController extends Controller
{
	public function pages($token, $page=null,  Request $request)
	{
		$packageCont = new PackageController;

		$package = $packageCont->model()->byIsLocked()
							->byToken($token)->firstOrFail();
		if ($page == 'compare') {
			$packageCont->model()->byIsLocked()
										->byToken($request->compare_token)
											->firstOrFail();
		}

		$package->costToken = $request->ctk;
		
		if ($package->cost->total_cost < 1) exitView();

		$url = $request->fullUrl();
		
		if (is_null($page)) {
			$page = 'home';
			$url = str_replace($token, $token.'/'.$page, $url);
		}

		$tempUrl = str_replace($token.'/'.$page, $token.'/{}', $url);

		$urlObj = new UrlController(['url' => $tempUrl]);

		$blade = [
				"url" => $url,
				"token" => $token,
				"urlObj" => $urlObj,
				"package" => $package,
			];

		return view('subway.pages.'.$page, $blade);
	}



}
