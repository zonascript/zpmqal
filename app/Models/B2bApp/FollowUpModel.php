<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class FollowUpModel extends Model
{
	protected $table =  'follow_ups';

	public function package()
	{
		return $this->belongsTo('App\Models\B2bApp\PackageModel', 'package_id');
	}
}
