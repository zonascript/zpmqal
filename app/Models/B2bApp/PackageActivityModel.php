<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class PackageActivityModel extends Model
{

	protected $table  = 'package_activities';
	protected $hidden = ['created_at', 'updated_at'];

	public static function call(){
		return new PackageActivityModel;
	}

	public function activity()
	{
		return $this->morphTo();
	}
	

	public function findByRouteId($rid)
	{
		return $this->where(['route_id' => $rid, 'is_active' => 1])->get();
	}



	public function activityObject($attribute = [])
	{
		$activity = $this->activity;
		if (!is_null($activity)) {
			$ukey = $activity->vendor.'_'.$activity->id;
			$name = $activity->title;
			$image = $activity->image_url;
			$description = $activity->description;
			

			if ($activity->vendor == 'f') {
				$name = $activity->name;
			}
			elseif ($activity->vendor == 'v') {
				$image = $activity->thumbnailURL;
				$description = $activity->shortDescription;
			}

			$result = [
					'ukey' => $ukey,
					'code' => $activity->id,
					'vendor' => $activity->vendor,
					'image' => $image,
					'name' => $name,
					'description' => $description,
					'date' => $this->date,
					'timing' => $this->timing,
					'mode' => $this->mode,
					'isSelected' => 1
				];
			
			if (in_array('images', $attribute)) {
				$result['images'] = $this->images();
				$result['images'][] = $result['image'];
				$result['images'] = array_unique($result['images']);
			}

			return (object) $result;
		}
	}

	public function images()
	{
		$images = [];
		$imageData = $this->activity->images;

		foreach ($imageData as $image) {
			$images[] = $image->url;
		}
		return $images;
	}

}
