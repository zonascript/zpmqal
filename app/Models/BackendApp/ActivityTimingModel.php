<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;

class ActivityTimingModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'activities_timings';
}
