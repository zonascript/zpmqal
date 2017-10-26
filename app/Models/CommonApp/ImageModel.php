<?php

namespace App\Models\CommonApp;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
	protected $table = 'images';
	protected $connection = 'mysql2';
	protected $appends = ['url'];
	protected $guarded = ['id'];
	protected $hidden = [
							'id', 'type', 'status', 'path_or_url', 'image_path', 
							'connectable_id', 'connectable_type','is_active	',
							'created_at', 'updated_at'
					];

	public function getUrlAttribute()
	{
		if ($this->type == 'path') {
			$url = urlImage($this->image_path);			
		}
		return $url;
	}


	public function connectable()
	{
		return  $this->morphTo();
	}



	/*
	| $data must be like : ['path' => '', 'host' => '']
	*/
	public function makeAndSave(Array $data, $cid, $ctype)
	{
		$array = [];
		foreach ($data as $value) {
			if (isset($value['path'])) {
				$array[] = addDateColumns([
												"type" => 'path',
												"image_path" => $value['path'],
												"connectable_id"	=> $cid,
												"connectable_type"	=> $ctype,
											]);
			}
		}

		return $this->insert($array);
	}

}
