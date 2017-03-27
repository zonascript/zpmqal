<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class DestinationModel extends Model
{
	protected $table = 'destinations';

	protected $appends = ['location'];

	public function getLocationAttribute()
	{
		return echoLocation($this->attributes['country'], $this->attributes['destination']);
	}

}
