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
		return [
							'path' => $imagePath, 
							'host' => 'http://'.env('IMAGE_DOMAIN')
						];
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

		return json_encode(['status' => 200, 'response' => 'deleted successfully.']);

	}


	public function createOrUpdate(Request $request, $id)
	{
		$image = $this->model()->find($id);
		if (is_null($image)) {
			$image = $this->model();
		}

		$image->type = $request->type;
		$image->image_path = $request->image_path;
		$image->caption = $request->caption;
		$image->connectable_id = $request->connectable_id;
		$image->connectable_type = $request->connectable_type;
		$image->save();
		return $image;
	}

}
