<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class UnionActivityModel extends Model
{
	protected $table = 'union_activities';

	protected $casts = [
		'request' => 'object',
		'result' => 'object'
	];


	public function setRequestAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['request'] = $value;
	}

	public function setResultAttribute($value)
	{
		if (is_array($value) || is_object($value)) {
			$value = json_encode($value);
		}
		$this->attributes['result'] = $value;
	}

}
