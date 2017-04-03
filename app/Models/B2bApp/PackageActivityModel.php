<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;
use DB;

class PackageActivityModel extends Model
{

	protected $table  = 'package_activities';
	protected $appends = ['activities_detail'];
	protected $casts = [
			'selected_activities' => 'object'
		];

	protected $hidden = [
			'created_at', 'updated_at',
		];


	public static function call(){
		return new PackageActivityModel;
	}


	public function setStatusAttribute($value)
	{
		$this->attributes['status'] = strtolower($value);
	}

	
	public function setSelectedActivitiesAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['selected_activities'] = $value;
	}


	public function getActivitiesDetailAttribute()
	{
		$selectedActivities = null;

		if (isset($this->union->result)) {
			$activities = $this->union->result;
			$selectedActivities = $this->selected_activities;

			if (is_array($activities) && is_object($selectedActivities)) {
				foreach ($activities as $key => $value) {
					$code = $value->code;
					if (isset($selectedActivities->$code)) {
						$selectedActivities->$code->detail = $value;
					}
				}
			}
		}

		return $selectedActivities;
	}

	/*
	| this function is for getting route of that route
	*/
	public function route()
	{
		return $this->belongsTo('App\Models\B2bApp\RouteModel', 'route_id');		
	}


	public function hotel()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageHotelModel', 'package_hotel_id');		
	}

	/*
	| Getting flygoldfinch's all activities
	*/
	public function fgf()
	{
		return $this->belongsTo('App\Models\Api\FgfActivityModel', 'fgf_activity_id');		
	}

	/*
	| Getting viator's all activities
	*/
	public function viator()
	{
		return $this->belongsTo('App\Models\Api\ViatorActivityModel', 'viator_activity_id');		
	}


	/*
	| Getting viator's all activities
	*/
	public function union()
	{
		return $this->belongsTo('App\Models\Api\UnionActivityModel', 'union_activity_id');		
	}


	public function selectedActivities()
	{
		$result = $this->hasMany('App\Models\B2bApp\SelectedActivityModel', 'package_activity_id');
		return $result->where([['is_active', '>', 0]])->orderBy('date', 'asc');
	}



}
