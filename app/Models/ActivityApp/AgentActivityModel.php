<?php

namespace App\Models\ActivityApp;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CallTrait;


class AgentActivityModel extends Model
{
	use CallTrait;

	protected $connection = 'mysql6';
	protected $table = 'agent_activities';
	protected $appends = ['vendor', 'image_url'];


	public function setAdminIdAttribute($value = '')
	{
		$this->attributes['admin_id'] = $this->checkUser();
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
		if (!is_null($code)) {
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


	public function openUrl()
	{
		return url('dashboard/inventories/activity/'.$this->id);
	}



	public function __construct(array $attributes = [])
	{
		$this->setAdminIdAttribute();
		parent::__construct($attributes);
	}
}
