<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class TrackPackageModel extends Model
{
	protected $table = 'track_packages';
	protected $appends = ['stay_time'];
	
	public static function call()
	{
		return new TrackPackageModel;
	}

	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}

	public function getStayTimeAttribute()
	{
		return convertSeconds($this->time_duration,false);
	}


	public function fatchTracks($take = 25)
	{
		return $this->with('package')
									->whereHas('package', function($q) {
												$q->where('user_id','=', auth()->user()->id);
											})
										->simplePaginate($take);
	}

	
	public function activeTracks($skip = 0, $take = 25)
	{
		return $this->where(['status' => 1])
									->with('package')
										->whereHas('package', function($q) {
													$q->where('user_id','=', auth()->user()->id);
												})
											->skip($skip)
												->take($take)
													->get();
	}
}
