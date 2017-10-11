<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;


class AgentActivityModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql6';
	protected $table = 'agent_activities';
	protected $appends = ['vendor', 'image_url', 'duration_to_human'];


	public function setAdminIdAttribute($value = '')
	{
		$this->attributes['admin_id'] = $this->checkUser();
	}

	public function setDescriptionAttribute($value = '')
	{
		$this->attributes['description'] = clean_html($value);
	}

	public function setInclusionAttribute($value = '')
	{
		$this->attributes['inclusion'] = clean_html($value);
	}

	public function setExclusionAttribute($value = '')
	{
		$this->attributes['exclusion'] = clean_html($value);
	}

	public function getVendorAttribute()
	{
		return 'own';
	}

	public function getImageUrlAttribute()
	{
		return	$this->images->count()
					? $this->images[0]->url
					: urlImage('images/default/activity.png');
	}


	public function getDescriptionAttribute($value)
	{
		$change = strlen($value);
		$value = clean_html($value);
		
		if ($change != strlen($value)) {
			$this->description = $value;
			$this->save();
		}

		return $value;
	}


	public function getPickUpAttribute($value)
	{
		if ($value == '00:00:00') return null;
		return $value;
	}


	public function getDurationAttribute($value)
	{
		if ($value == '00:00:00') return null;
		return $value;
	}


	public function getDurationToHumanAttribute()
	{
		return convertInHourMin($this->duration);
	}

	public function images()
	{
		return $this->morphMany('App\Models\CommonApp\ImageModel', 'connectable');
	}


	public function destination()
	{
		return $this->belongsTo('App\Models\CommonApp\DestinationModel', 'destination_code');
	}


	public function status()
	{
		return $this->belongsTo('App\Models\CommonApp\IndicationModel', 'is_active');
	}


	public function scopeByAdmin($query)
	{
		return $query->where('admin_id', $this->checkUser());
	}


	public function scopeByDestinationCode($query, $code)
	{
		if (strlen($code)) {
			return $query->where('destination_code', $code);
		}
	}


	public function scopeByIsActive($query, $bool=1)
	{
		return $query->where('is_active', $bool);
	}


	public function scopeBySearch($query, $title)
	{
		return $query->where("title", 'like', '%'.$title.'%');
	}


	public function findByDestination($cityId, $title = '')
	{
		return $this->byAdmin()->bySearch($title)
									->byDestinationCode($cityId)
										->byIsActive()->skip(0)->take(20)->get();
	}



	public function checkUser()
	{
		$adminId = null;

		$domain = $_SERVER['HTTP_HOST'];

		if ($domain == env('B2B_DOMAIN')) {
			$auth = auth()->user();
			$adminId = $auth->admin->id;
		}
		elseif ($domain == env('ADMIN_DOMAIN')) {
			$auth = auth()->guard('admin')->user();
			$adminId = $auth->id;
		}

		return $adminId;
	}


	public function openUrl($seg = '')
	{
		return url('dashboard/inventories/activity/'.$this->id.'/'.$seg).'?city='.$this->destination_code;
	}



	public function __construct(array $attributes = [])
	{
		$this->setAdminIdAttribute();
		parent::__construct($attributes);
	}
}
