<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;
use App\Traits\CallTrait;
use Carbon\Carbon;
use DB;

class PackageActivityModel extends Model
{
	use CallTrait;

	protected $table  = 'package_activities';
	protected $appends = ['images', 'mode_name'];
	protected $hidden = ['created_at', 'updated_at'];

	public function getImagesAttribute()
	{
		return $this->images();
	}

	public function getModeNameAttribute()
	{
		$mode = IndicationModel::byCategory('act_mode')
						->byKey($this->mode)->first();

		return isset($mode->name) 
				 ? $mode->name
				 : str_replace('_', ' ', $this->mode);
	}

	public function scopeByIsActive($query, $bool = 1)
	{
		return $query->where('is_active', $bool);
	}

	public function scopeByRouteId($query, $id)
	{
		return $query->where('route_id', $id);
	}


	public function scopeByToken($query, $token)
	{
		$id = mydecrypt($token);
		return $query->where('id', $id);
	}


	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');
	}


	public function activity()
	{
		return $this->morphTo();
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

			$pickUp = is_null($this->pick_up) 
							 ? $activity->pick_up 
							 : $this->pick_up;
			
			$duration = is_null($this->duration)
								? $activity->duration
								: $this->duration;


			$result = [
					'pdid' => $this->id,
					'ukey' => $ukey,
					'code' => $activity->id,
					'vendor' => $activity->vendor,
					'image' => $image,
					'name' => $name,
					'description' => $description,
					'sort_description' => substr($description, 0, 750),
					'date' => $this->date,
					'timing' => $this->timing,
					'mode' => $this->mode,
					'mode_name' => $this->mode_name,
					'isSelected' => 1,
					'pick_up' => $pickUp,
					'duration' => $duration,
					'inclusion' => $activity->inclusion,
					'exclusion' => $activity->exclusion,
				];


			if (in_array('images', $attribute)) {
				$result['images'] = $this->images();
				$result['images'][] = $result['image'];
				$result['images'] = array_unique($result['images']);
			}

			return (object) $result;
		}
	}


	public function voucherData()
	{
		$data = $this->activityObject(['images']);
		$companyName = '-';
		$companyAddr = '-';
		$clientName = '';
		$pax = '';

		if (isset($this->route->package)) {
			$companyName = $this->route->package->user->admin->companyname;
			$companyAddr = $this->route->package->user->admin->address;
			$clientName = $this->route->package->client->fullname;
			$pax = $this->route->package->pax_detail;
		}

		$activity = (array) $this->activityObject();
		$activity['date'] = Carbon::parse($activity['date']); 
		$result = [
				"clientName" => $clientName,
				"companyName" => $companyName,
				"companyAddr" => $companyAddr,
				"pax" => $pax,
			];

		$result = array_merge($result,$activity);
		return (object)$result;
	}


	public function images()
	{

		$images = collect([]);
		if ($this->activity->vendor == 'v') {
			$images = $images->merge($this->activity->images);
		}
		else{
			$images = $images->merge($this->activity
													->images->pluck('url')
														->toArray());
		}
		
		return $images;
	}

}
