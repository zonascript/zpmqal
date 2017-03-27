<?php

namespace App\Http\Controllers\B2bApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
	public static function call()
	{
		return new ImagesController;
	}

	public function upload(Request $request)
	{
		$imagePath = imageUpload($request->file);
		return ['path' => $imagePath, 'host' => urlimage()];
	}


	public function download($name = '')
	{
		# code...
	}
}
