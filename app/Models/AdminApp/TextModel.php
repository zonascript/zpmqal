<?php

namespace App\Models\AdminApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\CommonApp\IndicationModel;

class TextModel extends Model
{
	protected $connection = 'mysql3';
	protected $appends = ['status', 'max_order'];
	protected $table = 'texts';


	public function setOrderAttribute($value)
	{
		if (!is_null($this->order)) {
			if (is_null($value)) {
				$this->attributes['order'] = $this->max_order;
			}
			else{
				$this->attributes['order'] = $value;
			}

		}
	}


	public function getStatusAttribute()
	{
		return is_null($this->indication) ? '' : $this->indication->name;
	}


	public function getMaxOrderAttribute()
	{
		$order = $this->select('order')
						->where(["admin_id" => auth()->guard('admin')->user()->id])
							->orderBy("order","desc")
								->first();

		return $order->order;
	}

	public function scopeAdminId($query)
	{
		$auth = auth()->guard('admin')->user();
		return $query->where('admin_id', $auth->id);
	}


	public function indication()
	{
		return $this->belongsTo(IndicationModel::class, 'is_active');
	}


	public function findByAdminId($adminId = null, array $where = [], $whereRaw = null)
	{
		$adminId = is_null($adminId) 
						 ? auth()->guard('admin')->user()->id 
						 : $adminId;
						 
		$where = array_merge(["admin_id" => $adminId], $where);
		return $this->where($where)
									->whereRaw($whereRaw)
										->orderBy("order","asc")
											->get();
	}



}
