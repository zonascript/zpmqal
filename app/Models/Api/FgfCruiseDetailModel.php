<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class FgfCruiseDetailModel extends Model
{
	protected $table = 'fgf_cruise_details';

	protected $casts = [
		'request' => 'object',
		'result' => 'object'
	];
}
