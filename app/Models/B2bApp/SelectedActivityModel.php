<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

// ===========================Other model===========================
use App\Models\Api\ActivityModel;
use App\Models\Api\AgentActivityModel;
use App\Models\Api\ViatorActivityModel;
use Carbon\Carbon;

class SelectedActivityModel extends Model
{
	protected $table = 'selected_activities';
	protected $appends = ['detail'];


	public function getDateAttribute($value)
	{
		return Carbon::parse($value);
	}


	public function getDetailAttribute()
	{
		$result = [];

		if ($this->vendor == 'f') {
			$result = ActivityModel::call()->findByCode($this->code);
		}
		elseif ($this->vendor == 'v') {
			$result = ViatorActivityModel::call()->findByCode($this->code);
		}
		elseif ($this->vendor == 'own') {
			$result = AgentActivityModel::call()->findByCode($this->code);
		}

		return $result;
	}

}
