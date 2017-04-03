<?php

namespace App\Models\B2bApp;

use Illuminate\Database\Eloquent\Model;

class ViatorActivityModel extends Model
{
	protected $table = 'viator_activities';

	public static function call(){
		return new ViatorActivityModel;
	}
}
