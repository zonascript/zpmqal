<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class TrackPackageModel extends Model
{
	protected $table = 'track_packages';
	
	public static function call()
	{
		return new TrackPackageModel;
	}

	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}
}
