<?php

namespace App\Models\BackendApp;

use Illuminate\Database\Eloquent\Model;

class ViatorDestinationModel extends Model
{
	protected $connection = 'mysql2';
	protected $table = 'viator_destinations';


	public function activities()
	{
		return $this->hasMany('App\Models\BackendApp\ViatorActivityModel', 'primaryDestinationId', 'destinationId');
	}

}
