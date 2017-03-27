<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use DB;

class ViatorActivityModel extends Model
{
	protected $table = 'viator_activities';


	public static function call(){
		return new ViatorActivityModel;
	}


}
