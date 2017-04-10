<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
	protected $table = 'images';
	protected $connection = 'mysql2';
	protected $hidden = [
							'id', 'relationId', 'type', 'status', 'path_or_url', 
							'imagePath', 'statusby', 'created_at', 'updated_at'
					];

	public function getUrlAttribute($url)
	{
		if ($this->type == 'path') {
			$url = urlImage().$this->imagePath;			
		}

		return $url;
	}
}
