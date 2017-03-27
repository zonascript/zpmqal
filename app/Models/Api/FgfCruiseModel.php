<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class FgfCruiseModel extends Model
{
	protected $table = 'fgf_cruises';

	protected $casts = [
		'request' => 'object',
		'result' => 'object'
	];
}
