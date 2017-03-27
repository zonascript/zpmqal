<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCostModel extends Model
{
	protected $table = 'package_costs';
	protected $appends = ['total_cost'];

	public function getTotalCostAttribute()
	{
		$netCost = isset($this->attributes['net_cost']) 
						 ? $this->attributes['net_cost'] 
						 : 0;

		$margin = isset($this->attributes['margin']) 
						 ? $this->attributes['margin'] 
						 : 0;

		return $netCost+$margin;
	}
}
