<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;

class TextModel extends Model
{
	protected $connection = 'mysql3';
	protected $table = 'texts';

	public function findByAdminId($adminId = null, array $where = [], $whereRaw = null)
	{
		$auth = auth()->guard('admin')->user();
		$adminId = is_null($adminId) ? $auth->id : $adminId;

		$where = array_merge(["admin_id" => $adminId], $where);
		
		if (is_null($whereRaw)) {
			$whereRaw = "`status` <> 'deleted'";
		}
		else{
			$where = array_merge($where, [["status", "<>", "deleted"]]);
		}
		
		return $this->select()
									->where($where)
										->whereRaw($whereRaw)
											->orderBy("order","asc")
												->get();
	}


}
