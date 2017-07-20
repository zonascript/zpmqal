<?php

namespace App\Http\Controllers\CommonApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CommonApp\ImageModel;
ini_set('max_execution_time', 3600);



class ImageController extends Controller
{
	public static function call()
	{
		return new ImageController;
	}

	public function model()
	{
		return new ImageModel;
	}

	public function upload(Request $request)
	{
		$imagePath = imageUpload($request->file);
		return ['path' => $imagePath, 'host' => urlimage()];
	}


	/*
	| remove image data from data base
	*/
	public function moveToTrash($id)
	{
		$image = $this->model()->find($id);
		
		if (!is_null($image)) {
			// $path = trashImage($image->path);
			// $image->trash_path = $path;
			$image->is_active = 0;
			$image->save();
		}

		return json_encode(['status' => 200, 'response' => 'deleted successfully.'])

	}

}
