<?php

namespace App\Http\Controllers\BackendApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// ======================================Models======================================
use App\Models\BackendApp\ImageModel;


class ImagesController extends Controller
{
	public static function call(){
		return new ImagesController;
	}

	public function model(){
		return new ImageModel; 
	}

	
	public function upload(Request $request)
	{
		$imagePath = imageUpload($request->file);
		return ['path' => $imagePath, 'host' => urlimage()];
	}

}
