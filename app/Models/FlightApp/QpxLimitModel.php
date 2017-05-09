<?php

namespace App\Models\FlightApp;

use Illuminate\Database\Eloquent\Model;

class QpxLimitModel extends Model
{
	protected $connection = 'mysql7';
	protected $table = 'qpx_limits';

	public static function call()
	{
		return new QpxLimitModel;
	}

	public function todayCalled($key)
	{
		$date = date("Y-m-d");
		$keys = $this->where(['key' => $key])
										->whereRaw('date(`created_at`) = \''.$date."'")
											->get();
		return $keys;
	}
}
