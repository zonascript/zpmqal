<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class PackageCostModel extends Model
{
	protected $table = 'package_costs';
	protected $appends = ['total_cost'];

	public function setTokenAttribute()
	{
		$this->attributes['token'] = mycrypt($this->count());
	}

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


	public function __construct(array $attributes = [])
	{
		$this->setTokenAttribute();
		parent::__construct($attributes);
	}
}
