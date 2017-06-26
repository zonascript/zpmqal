<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
	protected $table = 'images';
	protected $connection = 'mysql2';
	protected $hidden = [
							'id', 'type', 'status', 'path_or_url', 'image_path', 
							'connectable_id', 'connectable_type','is_active	',
							'created_at', 'updated_at'
					];

	public function getUrlAttribute($url)
	{
		if ($this->type == 'path') {
			$url = urlImage().$this->image_path;			
		}

		return $url;
	}

	public function connectable()
	{
		return  $this->morphTo();
	}

}
