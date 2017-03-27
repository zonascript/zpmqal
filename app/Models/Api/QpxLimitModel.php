<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;
class QpxLimitModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'qpx_limits';

	public static function call()
	{
		return new QpxLimitModel;
	}

	public function todayCalled($key)
	{
		$date = date("Y-m-d");
		$keys = $this->select()
									->where(['key' => $key])
										->whereRaw('date(`created_at`) = \''.$date."'")
											->get();
		return $keys;
	}
}
